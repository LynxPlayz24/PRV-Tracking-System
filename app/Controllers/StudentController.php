<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Examiner;
use App\Models\VivaRecord;
use App\Models\Correction;
use App\Models\Graduation;
use App\Models\Remark;
use App\Models\Chairperson;
use App\Models\HonorariumPayment;

class StudentController extends Controller
{
    private Student $studentModel;
    private Supervisor $supervisorModel;
    private Examiner $examinerModel;
    private VivaRecord $vivaModel;
    private Correction $correctionModel;
    private Graduation $graduationModel;
    private Remark $remarkModel;
    private Chairperson $chairpersonModel;
    private HonorariumPayment $honorariumModel;

    public function __construct()
    {
        $this->studentModel    = new Student();
        $this->supervisorModel = new Supervisor();
        $this->examinerModel   = new Examiner();
        $this->vivaModel       = new VivaRecord();
        $this->correctionModel = new Correction();
        $this->graduationModel = new Graduation();
        $this->remarkModel     = new Remark();
        $this->chairpersonModel = new Chairperson();
        $this->honorariumModel = new HonorariumPayment();
    }

    /**
     * Show full student detail page
     */
    public function detail(string $id): void
    {
        Middleware::requireLogin();
        
        $studentId = (int)$id;
        $student = $this->studentModel->getFullDetails($studentId);

        if (!$student) {
            $this->setFlash('danger', 'Student not found.');
            $this->redirect($this->baseUrl() . '/search');
            return;
        }

        $remarks = $this->remarkModel->getForStudent($studentId);

        $data = [
            'pageTitle'          => 'Student Details - ' . $student['name'],
            'currentPage'        => 'search',
            'student'            => $student,
            'remarks'            => $remarks,
            'honorariumPayments' => $this->honorariumModel->getForStudent($studentId),
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('students.detail', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * Admin: Show create student form
     */
    public function create(): void
    {
        Middleware::requireAdmin();

        // Generate a fresh CSRF token for the form.
        $this->generateCsrfToken();

        $data = [
            'pageTitle'    => 'Add New Student',
            'currentPage'  => 'create',
            'supervisors'  => $this->supervisorModel->getAll(),
            'examiners'    => $this->examinerModel->getAll(),
            'chairpersons' => $this->chairpersonModel->getAll(),
            'programmes'   => $this->studentModel->getProgrammes(),
            'schools'      => $this->studentModel->getSchools()
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('students.create', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * Admin: Store new student
     */
    public function store(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid CSRF token.');
            $this->redirect($this->baseUrl() . '/students/create');
            return;
        }

        $matricNo = trim($this->input('matric_no', ''));
        
        // Basic validation
        if (empty($matricNo) || empty($this->input('name'))) {
            $this->setFlash('danger', 'Matric Number and Name are required.');
            $this->redirect($this->baseUrl() . '/students/create');
            return;
        }

        // Check if Matric Number is already in use.
        if ($this->studentModel->findByMatricNo($matricNo)) {
            $this->setFlash('danger', 'Matric Number already exists.');
            $this->redirect($this->baseUrl() . '/students/create');
            return;
        }

        // Validate logical sequence of dates.
        if ($error = $this->validateLogicalDates($_POST)) {
            $this->setFlash('danger', $error);
            $this->redirect($this->baseUrl() . '/students/create');
            return;
        }

        // Use manual research status
        $programme = trim($this->input('programme', ''));
        if ($programme === '__custom__' || $programme === 'custom') {
            $programme = trim($this->input('programme_custom', ''));
        }

        $school = trim($this->input('school', ''));
        if ($school === '__custom__' || $school === 'custom') {
            $school = trim($this->input('school_custom', ''));
        }

        $researchStatus = trim($this->input('research_status', 'Thesis Submitted'));

        // 1. Create Student
        $studentId = $this->studentModel->create([
            'matric_no'       => $matricNo,
            'name'            => trim($this->input('name')),
            'programme'       => $programme,
            'school'          => $school,
            'degree_level'    => $this->input('degree_level'),
            'cohort'          => trim($this->input('cohort')),
            'its_receipt_date'=> $this->input('its_receipt_date'),
            'thesis_title'    => strtoupper(trim($this->input('thesis_title'))),
            'research_status' => $researchStatus
        ]);

        // 2. Assign Supervisors
        $mainSupervisors = $_POST['main_supervisors'] ?? [];
        $coSupervisors = $_POST['co_supervisors'] ?? [];
        
        foreach ($mainSupervisors as $supId) {
            if ($supId) $this->supervisorModel->assignToStudent($studentId, (int)$supId, 'main');
        }
        foreach ($coSupervisors as $supId) {
            if ($supId) $this->supervisorModel->assignToStudent($studentId, (int)$supId, 'co');
        }

        // 2B. Assign Examiners
        $internalExaminers = $_POST['internal_examiners'] ?? [];
        $externalExaminers = $_POST['external_examiners'] ?? [];
        
        foreach ($internalExaminers as $exId) {
            if ($exId) {
                $emailDate = $_POST['internal_examiner_email_date'][$exId] ?? null;
                $status = $_POST['internal_examiner_status'][$exId] ?? 'Pending';
                $reportDate = $_POST['internal_examiner_report_date'][$exId] ?? null;
                $this->examinerModel->assignToStudent($studentId, (int)$exId, 'Internal', $emailDate, $status, $reportDate);
            }
        }
        foreach ($externalExaminers as $exId) {
            if ($exId) {
                $emailDate = $_POST['external_examiner_email_date'][$exId] ?? null;
                $status = $_POST['external_examiner_status'][$exId] ?? 'Pending';
                $reportDate = $_POST['external_examiner_report_date'][$exId] ?? null;
                $this->examinerModel->assignToStudent($studentId, (int)$exId, 'External', $emailDate, $status, $reportDate);
            }
        }

        // Map first internal/external examiner IDs to viva_records columns
        $_POST['internal_examiner_id'] = !empty($internalExaminers[0]) ? (int)$internalExaminers[0] : null;
        $_POST['external_examiner_id'] = !empty($externalExaminers[0]) ? (int)$externalExaminers[0] : null;

        // 3. Create Viva Record
        $this->vivaModel->createOrUpdate($studentId, $_POST);

        // 4. Create Correction Record
        $this->correctionModel->createOrUpdate($studentId, $_POST);

        // 5. Create Graduation Record
        $this->graduationModel->createOrUpdate($studentId, $_POST);

        // 5B. Save per-examiner honorarium payments
        $this->honorariumModel->saveForStudent($studentId, $this->buildHonorariumPayments(
            $_POST['honorarium_chairperson'] ?? null,
            $_POST['honorarium_chairperson_date'] ?? null,
            $internalExaminers,
            $externalExaminers,
            $_POST['honorarium_internal'] ?? null,
            $_POST['honorarium_internal_date'] ?? null,
            $_POST['honorarium_external'] ?? null,
            $_POST['honorarium_external_date'] ?? null,
            $_POST['honorarium_internal_list'] ?? [],
            $_POST['honorarium_internal_date_list'] ?? [],
            $_POST['honorarium_external_list'] ?? [],
            $_POST['honorarium_external_date_list'] ?? [],
            $_POST['honorarium_refreshment'] ?? null,
            $_POST['honorarium_refreshment_date'] ?? null,
            $this->examinerModel->getForStudent($studentId)
        ));

        // 6. Sync Research Status automatically
        $this->syncStudentResearchStatus($studentId, $_POST);

        $this->setFlash('success', 'Student added successfully.');
        $this->redirect($this->baseUrl() . '/student/' . $studentId);
    }

    /**
     * Admin: Manage students page (DataTables-style list)
     */
    public function manage(): void
    {
        Middleware::requireAdmin();

        $this->generateCsrfToken();

        $db = \App\Core\Database::getInstance();

        // Retrieve distinct viva years for the year filter dropdown.
        $db->query('SELECT DISTINCT YEAR(v.viva_date) AS viva_year FROM viva_records v WHERE v.viva_date IS NOT NULL ORDER BY viva_year DESC');
        $vivaYears = array_column($db->resultSet(), 'viva_year');

        $selectedYear = $_GET['year'] ?? '';

        // Build query with optional year filter.
        if (!empty($selectedYear)) {
            $db->query('SELECT DISTINCT s.* FROM students s
                        INNER JOIN viva_records v ON s.student_id = v.student_id
                        WHERE YEAR(v.viva_date) = :viva_year
                        ORDER BY s.name ASC');
            $students = $db->resultSet([':viva_year' => (int)$selectedYear]);
        } else {
            $students = $this->studentModel->getAll();
        }

        $data = [
            'pageTitle'    => 'Manage Students',
            'currentPage'  => 'manage',
            'students'     => $students,
            'vivaYears'    => $vivaYears,
            'selectedYear' => $selectedYear
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('students.manage', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * Admin: Show edit form (reusing create view but populating data)
     */
    public function edit(string $id): void
    {
        Middleware::requireAdmin();
        
        $studentId = (int)$id;
        $student = $this->studentModel->getFullDetails($studentId);

        if (!$student) {
            $this->setFlash('danger', 'Student not found.');
            $this->redirect($this->baseUrl() . '/students/manage');
            return;
        }

        // Ensure a fresh CSRF token exists for the form
        $this->generateCsrfToken();

        $data = [
            'pageTitle'          => 'Edit Student',
            'currentPage'        => 'manage',
            'student'            => $student,
            'supervisors'        => $this->supervisorModel->getAll(),
            'examiners'          => $this->examinerModel->getAll(),
            'remarks'            => $this->remarkModel->getForStudent($studentId),
            'chairpersons'       => $this->chairpersonModel->getAll(),
            'programmes'         => $this->studentModel->getProgrammes(),
            'schools'            => $this->studentModel->getSchools(),
            'honorariumPayments' => $this->honorariumModel->getForStudent($studentId),
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('students.create', $data); // We reuse the form
        $this->view('layouts.footer', $data);
    }

    /**
     * Admin: Update student data
     */
    public function update(string $id): void
    {
        Middleware::requireAdmin();
        
        $studentId = (int)$id;

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid CSRF token.');
            $this->redirect($this->baseUrl() . '/students/edit/' . $studentId);
            return;
        }

        $matricNo = trim($this->input('matric_no', ''));
        $existing = $this->studentModel->findByMatricNo($matricNo);
        if ($existing && (int)$existing['student_id'] !== $studentId) {
            $this->setFlash('danger', 'Matric Number already in use by another student.');
            $this->redirect($this->baseUrl() . '/students/edit/' . $studentId);
            return;
        }

        // Validate logical dates
        if ($error = $this->validateLogicalDates($_POST)) {
            $this->setFlash('danger', $error);
            $this->redirect($this->baseUrl() . '/students/edit/' . $studentId);
            return;
        }

        $programme = trim($this->input('programme', ''));
        if ($programme === '__custom__' || $programme === 'custom') {
            $programme = trim($this->input('programme_custom', ''));
        }

        $school = trim($this->input('school', ''));
        if ($school === '__custom__' || $school === 'custom') {
            $school = trim($this->input('school_custom', ''));
        }

        $researchStatus = trim($this->input('research_status', 'Thesis Submitted'));

        // 1. Update Student
        $this->studentModel->update($studentId, [
            'matric_no'       => $matricNo,
            'name'            => trim($this->input('name')),
            'programme'       => $programme,
            'school'          => $school,
            'degree_level'    => $this->input('degree_level'),
            'cohort'          => trim($this->input('cohort')),
            'its_receipt_date'=> $this->input('its_receipt_date'),
            'thesis_title'    => strtoupper(trim($this->input('thesis_title'))),
            'research_status' => $researchStatus
        ]);

        // 2. Update Supervisors (Remove all, then add)
        $this->supervisorModel->removeAllFromStudent($studentId);
        $mainSupervisors = $_POST['main_supervisors'] ?? [];
        $coSupervisors = $_POST['co_supervisors'] ?? [];
        
        foreach ($mainSupervisors as $supId) {
            if ($supId) $this->supervisorModel->assignToStudent($studentId, (int)$supId, 'main');
        }
        foreach ($coSupervisors as $supId) {
            if ($supId) $this->supervisorModel->assignToStudent($studentId, (int)$supId, 'co');
        }

        // 2B. Update Examiners (Remove all, then add)
        $this->examinerModel->removeAllFromStudent($studentId);
        $internalExaminers = $_POST['internal_examiners'] ?? [];
        $externalExaminers = $_POST['external_examiners'] ?? [];
        
        foreach ($internalExaminers as $exId) {
            if ($exId) {
                $emailDate = $_POST['internal_examiner_email_date'][$exId] ?? null;
                $status = $_POST['internal_examiner_status'][$exId] ?? 'Pending';
                $reportDate = $_POST['internal_examiner_report_date'][$exId] ?? null;
                $this->examinerModel->assignToStudent($studentId, (int)$exId, 'Internal', $emailDate, $status, $reportDate);
            }
        }
        foreach ($externalExaminers as $exId) {
            if ($exId) {
                $emailDate = $_POST['external_examiner_email_date'][$exId] ?? null;
                $status = $_POST['external_examiner_status'][$exId] ?? 'Pending';
                $reportDate = $_POST['external_examiner_report_date'][$exId] ?? null;
                $this->examinerModel->assignToStudent($studentId, (int)$exId, 'External', $emailDate, $status, $reportDate);
            }
        }

        // Map first internal/external examiner IDs to viva_records columns
        $_POST['internal_examiner_id'] = !empty($internalExaminers[0]) ? (int)$internalExaminers[0] : null;
        $_POST['external_examiner_id'] = !empty($externalExaminers[0]) ? (int)$externalExaminers[0] : null;

        // Map re-viva examiner arrays to scalar IDs for viva_records columns
        $_POST['reviva_internal_examiner_id'] = !empty($_POST['reviva_internal_examiners'][0]) ? (int)$_POST['reviva_internal_examiners'][0] : null;
        $_POST['reviva_external_examiner_id'] = !empty($_POST['reviva_external_examiners'][0]) ? (int)$_POST['reviva_external_examiners'][0] : null;

        // 3. Update related records
        $this->vivaModel->createOrUpdate($studentId, $_POST);
        $this->correctionModel->createOrUpdate($studentId, $_POST);
        $this->graduationModel->createOrUpdate($studentId, $_POST);

        // 3B. Save per-examiner honorarium payments
        $this->honorariumModel->saveForStudent($studentId, $this->buildHonorariumPayments(
            $_POST['honorarium_chairperson'] ?? null,
            $_POST['honorarium_chairperson_date'] ?? null,
            $internalExaminers,
            $externalExaminers,
            $_POST['honorarium_internal'] ?? null,
            $_POST['honorarium_internal_date'] ?? null,
            $_POST['honorarium_external'] ?? null,
            $_POST['honorarium_external_date'] ?? null,
            $_POST['honorarium_internal_list'] ?? [],
            $_POST['honorarium_internal_date_list'] ?? [],
            $_POST['honorarium_external_list'] ?? [],
            $_POST['honorarium_external_date_list'] ?? [],
            $_POST['honorarium_refreshment'] ?? null,
            $_POST['honorarium_refreshment_date'] ?? null,
            $this->examinerModel->getForStudent($studentId)
        ));

        // Sync Research Status automatically
        $this->syncStudentResearchStatus($studentId, $_POST);

        $this->setFlash('success', 'Student updated successfully.');
        $this->redirect($this->baseUrl() . '/student/' . $studentId);
    }

    /**
     * Admin: Delete student
     */
    public function delete(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/students/manage');
            return;
        }

        $this->studentModel->delete((int)$id);
        $this->setFlash('success', 'Student deleted successfully.');
        $this->redirect($this->baseUrl() . '/students/manage');
    }
    /**
     * Admin: Bulk delete students
     */
    public function bulkDelete(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/students/manage');
            return;
        }

        $idsString = trim($this->input('student_ids', ''));
        if (empty($idsString)) {
            $this->setFlash('danger', 'No students selected.');
            $this->redirect($this->baseUrl() . '/students/manage');
            return;
        }

        // Parse and sanitize the IDs
        $ids = array_filter(array_map('intval', explode(',', $idsString)));

        if (empty($ids)) {
            $this->setFlash('danger', 'No valid students selected.');
            $this->redirect($this->baseUrl() . '/students/manage');
            return;
        }

        $count = $this->studentModel->deleteMultiple($ids);
        $this->setFlash('success', "Successfully deleted {$count} student(s).");
        $this->redirect($this->baseUrl() . '/students/manage');
    }

    /**
     * Add remark with optional file upload for a student
     */
    public function addRemark(string $id): void
    {
        Middleware::requireLogin();

        $studentId = (int)$id;
        $student = $this->studentModel->findById($studentId);
        if (!$student) {
            $this->setFlash('danger', 'Student not found.');
            $this->redirect($this->baseUrl() . '/search');
            return;
        }

        $redirectUrl = $this->input('redirect_to') === 'edit' 
            ? '/students/edit/' . $studentId . '#remarks'
            : '/student/' . $studentId . '#tab-remarks';

        $remarkText = trim($this->input('remark_text', ''));
        if (empty($remarkText)) {
            $this->setFlash('danger', 'Remark text cannot be empty.');
            $this->redirect($this->baseUrl() . $redirectUrl);
            return;
        }

        $authorName = $_SESSION['user_name'] ?? $_SESSION['user']['name'] ?? 'Staff User';

        $fileData = [
            'file_path' => null,
            'file_name' => null,
            'file_type' => null,
            'file_size' => null
        ];

        // Handle File Attachment Upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['attachment'];
            $maxSize = 10 * 1024 * 1024; // 10 MB

            if ($file['size'] > $maxSize) {
                $this->setFlash('danger', 'File exceeds the maximum 10MB size limit.');
                $this->redirect($this->baseUrl() . $redirectUrl);
                return;
            }

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'zip', 'xlsx', 'csv'];

            if (!in_array($ext, $allowedExts)) {
                $this->setFlash('danger', 'Invalid file type. Allowed formats: PDF, DOC/DOCX, Images, TXT, ZIP, Excel.');
                $this->redirect($this->baseUrl() . $redirectUrl);
                return;
            }

            $uploadDir = dirname(__DIR__, 2) . '/public/uploads/remarks/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filename = 'remark_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $fileData['file_path'] = 'uploads/remarks/' . $filename;
                $fileData['file_name'] = $file['name'];
                $fileData['file_type'] = $file['type'] ?: $ext;
                $fileData['file_size'] = $file['size'];
            }
        }

        $this->remarkModel->create([
            'student_id'  => $studentId,
            'author_name' => $authorName,
            'remark_text' => $remarkText,
            'file_path'   => $fileData['file_path'],
            'file_name'   => $fileData['file_name'],
            'file_type'   => $fileData['file_type'],
            'file_size'   => $fileData['file_size']
        ]);

        $this->setFlash('success', 'Remark added successfully.');
        $this->redirect($this->baseUrl() . $redirectUrl);
    }

    /**
     * Delete a remark attachment
     */
    public function deleteRemark(string $id, string $remarkId): void
    {
        Middleware::requireLogin();

        $studentId = (int)$id;
        $remId = (int)$remarkId;

        $remark = $this->remarkModel->getById($remId);
        if ($remark && $remark['student_id'] == $studentId) {
            if (!empty($remark['file_path'])) {
                $fullPath = dirname(__DIR__, 2) . '/public/' . $remark['file_path'];
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
            $this->remarkModel->delete($remId);
            $this->setFlash('success', 'Remark deleted successfully.');
        } else {
            $this->setFlash('danger', 'Remark not found.');
        }

        $redirectUrl = $this->input('redirect_to') === 'edit' 
            ? '/students/edit/' . $studentId . '#remarks'
            : '/student/' . $studentId . '#tab-remarks';

        $this->redirect($this->baseUrl() . $redirectUrl);
    }

    /**
     * Derives research_status from saved viva/correction/graduation data
     * and updates the student record if the derived stage is higher than current.
     */
    private function syncStudentResearchStatus(int $studentId, array $post): void
    {
        $order = [
            'Thesis Submitted'      => 1,
            'Examiner Assigned'     => 2,
            'Viva Scheduled'        => 3,
            'Viva Completed'        => 4,
            'Re-Viva'               => 5,
            'Corrections Submitted' => 6,
            'Ready for Senate'      => 7,
            'Graduated'             => 8,
        ];

        $current = $this->studentModel->findById($studentId)['research_status'] ?? 'Thesis Submitted';

        // Derive status from data signals
        $graduationDate   = $post['graduation_date'] ?? '';
        $senateMeetingDate = $post['senate_meeting_date'] ?? '';
        $finalResult      = $post['final_result'] ?? '';
        $correctedThesis  = $post['corrected_thesis_received_date'] ?? '';
        $vivaResult       = $post['viva_result'] ?? '';
        $vivaDate         = $post['viva_date'] ?? '';

        if (!empty($graduationDate) && $graduationDate !== '0000-00-00') {
            $derived = 'Graduated';
        } elseif (!empty($senateMeetingDate) && $senateMeetingDate !== '0000-00-00') {
            $derived = 'Ready for Senate';
        } elseif (!empty($finalResult)) {
            $derived = 'Ready for Senate';
        } elseif (!empty($correctedThesis)) {
            $derived = 'Corrections Submitted';
        } elseif (!empty($vivaResult) && (stripos($vivaResult, 're-viva') !== false || stripos($vivaResult, 're-examination') !== false)) {
            $derived = 'Re-Viva';
        } elseif (!empty($vivaResult)) {
            $derived = 'Viva Completed';
        } elseif (!empty($vivaDate) && strtotime($vivaDate) <= time()) {
            $derived = 'Viva Completed';
        } else {
            // Nothing to upgrade — keep current
            return;
        }

        // Only update if derived is a higher stage than current
        $currentRank = $order[$current] ?? 1;
        $derivedRank = $order[$derived] ?? 1;

        if ($derivedRank > $currentRank) {
            $student = $this->studentModel->findById($studentId);
            if ($student) {
                $student['research_status'] = $derived;
                $this->studentModel->update($studentId, $student);
            }
        }
    }

    /**
     * Validates that dates logically progress in chronological order.
     * Returns an error message string if invalid, or null if all checks pass.
     */
    private function validateLogicalDates(array $data): ?string
    {
        $vivaDate             = !empty($data['viva_date']) ? strtotime($data['viva_date']) : null;
        $draftSubmissionDate  = !empty($data['draft_submission_form_date']) ? strtotime($data['draft_submission_form_date']) : null;
        $correctionDeadline   = !empty($data['correction_deadline']) ? strtotime($data['correction_deadline']) : null;
        $graduationDate       = !empty($data['graduation_date']) ? strtotime($data['graduation_date']) : null;
        $senateMeetingDate    = !empty($data['senate_meeting_date']) ? strtotime($data['senate_meeting_date']) : null;

        // Rule 1: viva_date cannot be earlier than draft_submission_form_date
        if ($vivaDate !== null && $draftSubmissionDate !== null && $vivaDate < $draftSubmissionDate) {
            return 'Viva Date cannot be earlier than Draft Submission Form Date ('
                . date('d M Y', $draftSubmissionDate) . ').';
        }

        // Rule 2: correction_deadline cannot be earlier than viva_date
        if ($correctionDeadline !== null && $vivaDate !== null && $correctionDeadline < $vivaDate) {
            return 'Correction Deadline cannot be earlier than Viva Date ('
                . date('d M Y', $vivaDate) . ').';
        }

        // Rule 3: graduation_date cannot be earlier than senate_meeting_date
        if ($graduationDate !== null && $senateMeetingDate !== null && $graduationDate < $senateMeetingDate) {
            return 'Graduation Date cannot be earlier than Senate Meeting Date ('
                . date('d M Y', $senateMeetingDate) . ').';
        }

        return null;
    }

    /**
     * Build the payments array for HonorariumPayment::saveForStudent().
     * Handles 1 or many internal/external examiners along with payment dates.
     */
    private function buildHonorariumPayments(
        ?string $chairAmount,
        ?string $chairDate,
        array $internalIds,
        array $externalIds,
        ?string $singleIntAmount,
        ?string $singleIntDate,
        ?string $singleExtAmount,
        ?string $singleExtDate,
        array $intList,       // ['examiner_id' => amount, ...]
        array $intDateList,   // ['examiner_id' => date, ...]
        array $extList,       // ['examiner_id' => amount, ...]
        array $extDateList,   // ['examiner_id' => date, ...]
        ?string $refreshAmount,
        ?string $refreshDate,
        array $examinerRows   // from Examiner::getForStudent
    ): array {
        $payments = [];

        // Chairperson
        if (($chairAmount !== null && $chairAmount !== '') || !empty($chairDate)) {
            $payments[] = [
                'role'         => 'Chairperson',
                'staff_name'   => null,
                'examiner_id'  => null,
                'amount'       => $chairAmount,
                'payment_date' => $chairDate ?: null
            ];
        }

        // Build examiner name lookup
        $examinerNames = [];
        foreach ($examinerRows as $row) {
            $examinerNames[(int)$row['examiner_id']] = $row['examiner_name'];
        }

        // Internal examiners
        if (count($internalIds) === 1) {
            $exId = (int)$internalIds[0];
            if ($exId && (($singleIntAmount !== null && $singleIntAmount !== '') || !empty($singleIntDate))) {
                $payments[] = [
                    'role'         => 'Internal',
                    'staff_name'   => $examinerNames[$exId] ?? null,
                    'examiner_id'  => $exId,
                    'amount'       => $singleIntAmount,
                    'payment_date' => $singleIntDate ?: null
                ];
            }
        } elseif (count($internalIds) > 1) {
            foreach ($internalIds as $exId) {
                $exId = (int)$exId;
                if (!$exId) continue;
                $amount = $intList[$exId] ?? null;
                $date = $intDateList[$exId] ?? null;
                if (($amount === null || $amount === '') && empty($date)) continue;
                $payments[] = [
                    'role'         => 'Internal',
                    'staff_name'   => $examinerNames[$exId] ?? null,
                    'examiner_id'  => $exId,
                    'amount'       => $amount,
                    'payment_date' => $date ?: null
                ];
            }
        }

        // External examiners
        if (count($externalIds) === 1) {
            $exId = (int)$externalIds[0];
            if ($exId && (($singleExtAmount !== null && $singleExtAmount !== '') || !empty($singleExtDate))) {
                $payments[] = [
                    'role'         => 'External',
                    'staff_name'   => $examinerNames[$exId] ?? null,
                    'examiner_id'  => $exId,
                    'amount'       => $singleExtAmount,
                    'payment_date' => $singleExtDate ?: null
                ];
            }
        } elseif (count($externalIds) > 1) {
            foreach ($externalIds as $exId) {
                $exId = (int)$exId;
                if (!$exId) continue;
                $amount = $extList[$exId] ?? null;
                $date = $extDateList[$exId] ?? null;
                if (($amount === null || $amount === '') && empty($date)) continue;
                $payments[] = [
                    'role'         => 'External',
                    'staff_name'   => $examinerNames[$exId] ?? null,
                    'examiner_id'  => $exId,
                    'amount'       => $amount,
                    'payment_date' => $date ?: null
                ];
            }
        }

        // Refreshment
        if (($refreshAmount !== null && $refreshAmount !== '') || !empty($refreshDate)) {
            $payments[] = [
                'role'         => 'Refreshment',
                'staff_name'   => null,
                'examiner_id'  => null,
                'amount'       => $refreshAmount,
                'payment_date' => $refreshDate ?: null
            ];
        }

        return $payments;
    }
}
