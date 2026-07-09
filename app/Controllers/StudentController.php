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

class StudentController extends Controller
{
    private Student $studentModel;
    private Supervisor $supervisorModel;
    private Examiner $examinerModel;
    private VivaRecord $vivaModel;
    private Correction $correctionModel;
    private Graduation $graduationModel;

    public function __construct()
    {
        $this->studentModel = new Student();
        $this->supervisorModel = new Supervisor();
        $this->examinerModel = new Examiner();
        $this->vivaModel = new VivaRecord();
        $this->correctionModel = new Correction();
        $this->graduationModel = new Graduation();
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

        $data = [
            'pageTitle'   => 'Student Details - ' . $student['name'],
            'currentPage' => 'search',
            'student'     => $student
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
            'pageTitle'   => 'Add New Student',
            'currentPage' => 'create',
            'supervisors' => $this->supervisorModel->getAll(),
            'examiners'   => $this->examinerModel->getAll()
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
        $status = $this->input('research_status', 'Thesis Submitted');

        // 1. Create Student
        $studentId = $this->studentModel->create([
            'matric_no'       => $matricNo,
            'name'            => trim($this->input('name')),
            'programme'       => trim($this->input('programme')),
            'school'          => trim($this->input('school')),
            'degree_level'    => $this->input('degree_level'),
            'thesis_title'    => trim($this->input('thesis_title')),
            'research_status' => $status
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

        // 3. Create Viva Record
        $this->vivaModel->createOrUpdate($studentId, $_POST);

        // 4. Create Correction Record
        $this->correctionModel->createOrUpdate($studentId, $_POST);

        // 5. Create Graduation Record
        $this->graduationModel->createOrUpdate($studentId, $_POST);

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
        $data = [
            'pageTitle'   => 'Manage Students',
            'currentPage' => 'manage',
            'students'    => $this->studentModel->getAll()
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
            'pageTitle'   => 'Edit Student',
            'currentPage' => 'manage',
            'student'     => $student,
            'supervisors' => $this->supervisorModel->getAll(),
            'examiners'   => $this->examinerModel->getAll()
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

        $status = $this->input('research_status', 'Thesis Submitted');

        // 1. Update Student
        $this->studentModel->update($studentId, [
            'matric_no'       => $matricNo,
            'name'            => trim($this->input('name')),
            'programme'       => trim($this->input('programme')),
            'school'          => trim($this->input('school')),
            'degree_level'    => $this->input('degree_level'),
            'thesis_title'    => trim($this->input('thesis_title')),
            'research_status' => $status
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

        // 3. Update related records
        $this->vivaModel->createOrUpdate($studentId, $_POST);
        $this->correctionModel->createOrUpdate($studentId, $_POST);
        $this->graduationModel->createOrUpdate($studentId, $_POST);

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

}
