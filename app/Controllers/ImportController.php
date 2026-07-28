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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Exception;

class ImportController extends Controller
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

    public function index(): void
    {
        Middleware::requireAdmin();

        $data = [
            'pageTitle'   => 'Import Students',
            'currentPage' => 'import'
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('import.index', $data);
        $this->view('layouts.footer', $data);
    }

    public function upload(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/import');
            return;
        }

        if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
            $this->setFlash('danger', 'Please upload a valid Excel file.');
            $this->redirect($this->baseUrl() . '/import');
            return;
        }

        $file = $_FILES['excel_file']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
            $this->setFlash('danger', 'Invalid file type. Only Excel or CSV allowed.');
            $this->redirect($this->baseUrl() . '/import');
            return;
        }

        // H3: Enforce file size limit (10 MB max).
        if ($_FILES['excel_file']['size'] > 10 * 1024 * 1024) {
            $this->setFlash('danger', 'File too large. Maximum allowed size is 10 MB.');
            $this->redirect($this->baseUrl() . '/import');
            return;
        }

        // H3: Validate MIME type with finfo for defense-in-depth.
        $allowedMimes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/csv',
            'text/plain',
            'application/csv',
            'application/octet-stream', // Some servers report xlsx as this
        ];
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $detectedMime = finfo_file($finfo, $file);
            finfo_close($finfo);
            if (!in_array($detectedMime, $allowedMimes) && !str_contains($detectedMime, 'spreadsheet') && !str_contains($detectedMime, 'excel') && !str_contains($detectedMime, 'zip')) {
                $this->setFlash('danger', 'File content does not match a valid Excel or CSV format (detected: ' . htmlspecialchars($detectedMime) . ').');
                $this->redirect($this->baseUrl() . '/import');
                return;
            }
        }

        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $headerRow = null;
            $secondHeaderRow = null;
            $headerIndex = 0;

            foreach ($rows as $index => $row) {
                $rowString = strtolower(implode(' ', array_map('strval', $row)));
                if (str_contains($rowString, 'nama pelajar') || str_contains($rowString, 'matrik') || str_contains($rowString, 'matric')) {
                    $headerRow = $row;
                    $secondHeaderRow = $rows[$index + 1] ?? [];
                    $headerIndex = $index;
                    break;
                }
            }

            if (!$headerRow) {
                $this->setFlash('danger', 'Invalid file format. Could not detect header row.');
                $this->redirect($this->baseUrl() . '/import');
                return;
            }

            // Combine the main header with the sub-header.
            $combinedHeader = [];
            foreach ($headerRow as $i => $col) {
                $col1 = trim(strval($col));
                $col2 = trim(strval($secondHeaderRow[$i] ?? ''));
                $combinedHeader[$i] = trim($col1 . ' ' . $col2);
            }

            $map = $this->mapHeaders($combinedHeader);
            $dataRows = array_slice($rows, $headerIndex + 2);

            if ($map['matric_no'] === -1 && $map['name'] === -1) {
                throw new Exception('Could not find required columns (Matric Number or Name).');
            }

            $successCount = 0;
            $skipCount = 0;
            $updateCount = 0;

            foreach ($dataRows as $row) {
                $matricNo = $this->getVal($row, $map['matric_no']);
                $name = $this->getVal($row, $map['name']);
                
                if (empty($matricNo) || empty($name)) {
                    $skipCount++; // M3: Count rows skipped due to missing required fields.
                    continue; 
                }

                $existingStudent = $this->studentModel->findByMatricNo($matricNo);
                
                $degree = $this->getVal($row, $map['degree_level'], 'Masters');
                if (stripos($degree, 'master') !== false) {
                    $degree = 'Masters';
                }

                $studentData = [
                    'matric_no'       => $matricNo,
                    'name'            => $name,
                    'programme'       => $this->getVal($row, $map['programme']),
                    'school'          => $this->getVal($row, $map['school']),
                    'degree_level'    => $degree,
                    'cohort'          => $this->getVal($row, $map['cohort']),
                    'its_receipt_date'=> $this->getDateVal($row, $map['its_receipt_date']),
                    'thesis_title'    => $this->getVal($row, $map['thesis_title']),
                    'research_status' => 'Thesis Submitted'
                ];

                $studentId = null;
                if ($existingStudent) {
                    // Update existing student record.
                    $studentId = $existingStudent['student_id'];
                    $studentData['research_status'] = $existingStudent['research_status']; // preserve status
                    $this->studentModel->update($studentId, $studentData);
                    $updateCount++;
                } else {
                    // Create new student record.
                    $studentId = $this->studentModel->create($studentData);
                    $successCount++;
                }

                // Process Supervisor assignments.
                $this->processSupervisors($studentId, $row, $map);

                // Process Viva records and Examiners.
                $this->processViva($studentId, $row, $map);

                // Process Correction records.
                $this->processCorrections($studentId, $row, $map);

                // Process Graduation records.
                $this->processGraduation($studentId, $row, $map);
            }

            $msg = "Import completed! Added $successCount new students. Updated $updateCount existing students.";
            if ($skipCount > 0) {
                $msg .= " Skipped $skipCount rows with missing Matric No or Name.";
            }
            $this->setFlash('success', $msg);

        } catch (Exception $e) {
            $this->setFlash('danger', 'Error processing file: ' . $e->getMessage());
        }

        $this->redirect($this->baseUrl() . '/students/manage');
    }

    private function getVal(array $row, int $index, ?string $default = null): ?string
    {
        if ($index === -1 || !isset($row[$index])) return $default;
        $val = trim((string)$row[$index]);
        return $val === '' ? $default : $val;
    }

    private function getDateVal(array $row, int $index): ?string
    {
        if ($index === -1 || !isset($row[$index])) return null;
        $val = trim((string)$row[$index]);
        if ($val === '' || $val === '-' || strtolower($val) === 'n/a') return null;

        // Check if value is an Excel numeric date.
        if (is_numeric($val)) {
            try {
                $dateTime = Date::excelToDateTimeObject($val);
                return $dateTime->format('Y-m-d');
            } catch (Exception $e) {
                return null;
            }
        }

        // Attempt standard date parsing.
        // Replace slashes with dashes so PHP's strtotime parses as DD-MM-YYYY instead of MM/DD/YYYY
        $cleanVal = str_replace('/', '-', $val);
        $time = strtotime($cleanVal);
        if ($time !== false && $time > 0) {
            return date('Y-m-d', $time);
        }
        return null;
    }

    private function mapHeaders(array $header): array
    {
        $map = [
            'matric_no' => -1, 'name' => -1, 'programme' => -1, 'school' => -1, 'degree_level' => -1, 
            'thesis_title' => -1, 'cohort' => -1, 'its_receipt_date' => -1,
            'supervisor_1' => -1, 'supervisor_2' => -1, 'supervisor_3' => -1,
            'jil_meeting_date' => -1, 'thesis_submission_email_date' => -1, 'draft_hard_copy_date' => -1,
            'draft_soft_copy_date' => -1, 'turnitin_percentage' => -1, 'draft_submission_form_date' => -1,
            'internal_examiner_email_date' => -1, 'external_examiner_email_date' => -1, 'panel_appointment_letter_date' => -1,
            'thesis_to_panel_hard_copy_date' => -1, 'thesis_to_panel_soft_copy_date' => -1, 'confirm_date_email_date' => -1,
            'invitation_letter_date' => -1, 'viva_date' => -1, 'viva_hari' => -1, 'viva_bulan' => -1, 'viva_tahun' => -1,
            'chairperson_name' => -1, 'internal_examiner_name' => -1,
            'internal_examiner_report_date' => -1, 'external_examiner_name' => -1, 'viva_result' => -1,
            'correction_deadline' => -1, 'reviewed_by' => -1, 'best_thesis_candidate' => -1, 'report_sent_to_student_date' => -1,
            'internal_report_status' => -1, 'external_report_status' => -1, 'honorarium_chairperson' => -1,
            'honorarium_internal' => -1, 'honorarium_external' => -1, 'honorarium_refreshment' => -1,
            'corrected_thesis_received_date' => -1, 'checklist_after_viva_date' => -1, 'correction_schedule_date' => -1,
            'post_viva_turnitin_percentage' => -1, 'supervisor_endorsement_date' => -1, 'sent_to_internal_date' => -1,
            'sent_to_external_date' => -1, 'sent_to_supervisor_date' => -1, 'endorsement_from_examiner_date' => -1,
            'abstract_received_date' => -1, 'final_result' => -1, 'gais_keyin_date' => -1, 'senate_meeting_date' => -1,
            'senate_status' => -1, 'thesis_certification_date' => -1, 'final_thesis_form_date' => -1, 
            'hard_bound_copies_date' => -1, 'loose_copy_date' => -1, 'cd_copies_date' => -1, 'etd_form_date' => -1,
            'sent_to_psb_date' => -1, 'graduation_date' => -1
        ];

        foreach ($header as $index => $colName) {
            if (!is_string($colName)) continue;
            $col = strtolower(trim(str_replace(["\n", "\r"], ' ', $colName)));

            // 1. Student Info
            if ($map['matric_no'] === -1 && (str_contains($col, 'matrik') || str_contains($col, 'matric'))) $map['matric_no'] = $index;
            elseif ($map['name'] === -1 && (str_contains($col, 'nama pelajar') || str_contains($col, 'student name'))) $map['name'] = $index;
            elseif ($map['programme'] === -1 && str_contains($col, 'program')) $map['programme'] = $index;
            elseif ($map['school'] === -1 && (str_contains($col, 'school') || str_contains($col, 'pengajian'))) $map['school'] = $index;
            elseif ($map['degree_level'] === -1 && (str_contains($col, 'level of degree') || str_contains($col, 'degree'))) $map['degree_level'] = $index;
            elseif ($map['thesis_title'] === -1 && (str_contains($col, 'tajuk') || str_contains($col, 'title'))) $map['thesis_title'] = $index;
            elseif ($map['cohort'] === -1 && (str_contains($col, 'cohort') || str_contains($col, 'thesis/cohort'))) $map['cohort'] = $index;

            // 2. Supervision
            elseif ($map['its_receipt_date'] === -1 && (str_contains($col, 'penerimaan its') || str_contains($col, 'tarikh penerimaan its'))) $map['its_receipt_date'] = $index;
            elseif ($map['supervisor_1'] === -1 && (str_contains($col, 'penyelia 1') || str_contains($col, 'main supervisor'))) $map['supervisor_1'] = $index;
            elseif ($map['supervisor_2'] === -1 && (str_contains($col, 'penyelia 2') || str_contains($col, 'co-supervisor 1'))) $map['supervisor_2'] = $index;
            elseif ($map['supervisor_3'] === -1 && (str_contains($col, 'penyelia 3') || str_contains($col, 'co-supervisor 2'))) $map['supervisor_3'] = $index;
            elseif ($map['jil_meeting_date'] === -1 && (str_contains($col, 'mesyuarat jil') || str_contains($col, 'bil. jil'))) $map['jil_meeting_date'] = $index;
            elseif ($map['thesis_submission_email_date'] === -1 && str_contains($col, 'emel thesis submission')) $map['thesis_submission_email_date'] = $index;
            elseif ($map['draft_hard_copy_date'] === -1 && str_contains($col, '4 hard copy')) $map['draft_hard_copy_date'] = $index;
            elseif ($map['draft_soft_copy_date'] === -1 && (str_contains($col, 'soft copy') && !str_contains($col, 'panel'))) $map['draft_soft_copy_date'] = $index;
            elseif ($map['turnitin_percentage'] === -1 && (str_contains($col, 'turnitin (%)') && !str_contains($col, 'selepas'))) $map['turnitin_percentage'] = $index;
            elseif ($map['draft_submission_form_date'] === -1 && str_contains($col, 'borang submission of draft')) $map['draft_submission_form_date'] = $index;

            // 3. Panel & Viva
            elseif ($map['internal_examiner_email_date'] === -1 && (str_contains($col, 'pemeriksa dalam') && str_contains($col, 'persetujuan'))) $map['internal_examiner_email_date'] = $index;
            elseif ($map['external_examiner_email_date'] === -1 && (str_contains($col, 'pemeriksa luar') && str_contains($col, 'persetujuan'))) $map['external_examiner_email_date'] = $index;
            elseif ($map['panel_appointment_letter_date'] === -1 && str_contains($col, 'surat pelantikan panel')) $map['panel_appointment_letter_date'] = $index;
            elseif ($map['thesis_to_panel_hard_copy_date'] === -1 && (str_contains($col, 'hard copy') && str_contains($col, 'panel'))) $map['thesis_to_panel_hard_copy_date'] = $index;
            elseif ($map['thesis_to_panel_soft_copy_date'] === -1 && str_contains($col, 'soft copy')) $map['thesis_to_panel_soft_copy_date'] = $index; // Fallback for 2nd soft copy
            elseif ($map['confirm_date_email_date'] === -1 && str_contains($col, 'confirm tarikh')) $map['confirm_date_email_date'] = $index;
            elseif ($map['invitation_letter_date'] === -1 && str_contains($col, 'surat jemputan')) $map['invitation_letter_date'] = $index;
            elseif ($map['viva_date'] === -1 && (str_contains($col, 'tarikh viva-voce') || str_contains($col, 'viva date') || str_contains($col, 'tarkh viva-voce'))) $map['viva_date'] = $index;
            elseif ($map['viva_hari'] === -1 && str_contains($col, 'hari') && (str_contains($col, 'viva') || $index > 20)) $map['viva_hari'] = $index;
            elseif ($map['viva_bulan'] === -1 && str_contains($col, 'bulan') && (str_contains($col, 'viva') || $index > 20)) $map['viva_bulan'] = $index;
            elseif ($map['viva_tahun'] === -1 && str_contains($col, 'tahun') && (str_contains($col, 'viva') || $index > 20)) $map['viva_tahun'] = $index;
            elseif ($map['chairperson_name'] === -1 && (str_contains($col, 'nama pengerusi') || str_contains($col, 'chairperson'))) $map['chairperson_name'] = $index;
            elseif ($map['internal_examiner_name'] === -1 && (str_contains($col, 'nama pemeriksa dalam') && !str_contains($col, 'penilaian'))) $map['internal_examiner_name'] = $index;
            elseif ($map['internal_examiner_report_date'] === -1 && str_contains($col, 'laporan penilaian pemeriksa dalam')) $map['internal_examiner_report_date'] = $index;
            elseif ($map['external_examiner_name'] === -1 && str_contains($col, 'nama pemeriksa luar')) $map['external_examiner_name'] = $index;
            elseif ($map['viva_result'] === -1 && (str_contains($col, 'keputusan') && !str_contains($col, 'akhir') && !str_contains($col, 'jil') && !str_contains($col, 'senat'))) $map['viva_result'] = $index;

            // 4. Post-Viva
            elseif ($map['correction_deadline'] === -1 && str_contains($col, 'tarikh akhir pembetulan')) $map['correction_deadline'] = $index;
            elseif ($map['reviewed_by'] === -1 && str_contains($col, 'semakan pembetulan oleh')) $map['reviewed_by'] = $index;
            elseif ($map['best_thesis_candidate'] === -1 && str_contains($col, 'calon tesis terbaik')) $map['best_thesis_candidate'] = $index;
            elseif ($map['report_sent_to_student_date'] === -1 && str_contains($col, 'hantar laporan pemeriksaan')) $map['report_sent_to_student_date'] = $index;
            elseif ($map['internal_report_status'] === -1 && (str_contains($col, 'laporan pemeriksa dalam') && !str_contains($col, 'nama') && !str_contains($col, 'tarikh'))) $map['internal_report_status'] = $index;
            elseif ($map['external_report_status'] === -1 && (str_contains($col, 'laporan pemeriksa luar') && !str_contains($col, 'nama') && !str_contains($col, 'tarikh'))) $map['external_report_status'] = $index;
            elseif ($map['honorarium_chairperson'] === -1 && str_contains($col, 'chairperson')) $map['honorarium_chairperson'] = $index; // Row 2 header
            elseif ($map['honorarium_internal'] === -1 && (str_contains($col, 'honorarium') && str_contains($col, 'dalam'))) $map['honorarium_internal'] = $index;
            elseif ($map['honorarium_external'] === -1 && str_contains($col, 'pemeriksa luar') && $index > $map['honorarium_internal']) $map['honorarium_external'] = $index; // Row 2 header after internal
            elseif ($map['honorarium_refreshment'] === -1 && (str_contains($col, 'refreshment') || str_contains($col, 'bayaran t&t'))) $map['honorarium_refreshment'] = $index;

            // 5. Corrected Thesis
            elseif ($map['corrected_thesis_received_date'] === -1 && (str_contains($col, 'tesis pembetulan') && !str_contains($col, 'penghantaran'))) $map['corrected_thesis_received_date'] = $index;
            elseif ($map['checklist_after_viva_date'] === -1 && str_contains($col, 'checklist after viva')) $map['checklist_after_viva_date'] = $index;
            elseif ($map['correction_schedule_date'] === -1 && str_contains($col, 'jadual pembetulan')) $map['correction_schedule_date'] = $index;
            elseif ($map['post_viva_turnitin_percentage'] === -1 && (str_contains($col, 'turnitin') && str_contains($col, 'berkaitan'))) $map['post_viva_turnitin_percentage'] = $index;
            elseif ($map['supervisor_endorsement_date'] === -1 && str_contains($col, 'pengesahan pembetulan oleh penyelia')) $map['supervisor_endorsement_date'] = $index;
            elseif ($map['sent_to_internal_date'] === -1 && (str_contains($col, 'penghantaran') && str_contains($col, 'pemeriksa dalam'))) $map['sent_to_internal_date'] = $index;
            elseif ($map['sent_to_external_date'] === -1 && str_contains($col, 'pemeriksa luar') && $index > $map['sent_to_internal_date']) $map['sent_to_external_date'] = $index; // Following internal
            elseif ($map['sent_to_supervisor_date'] === -1 && str_contains($col, 'penyelia') && $index > $map['sent_to_internal_date']) $map['sent_to_supervisor_date'] = $index; // Following internal
            elseif ($map['endorsement_from_examiner_date'] === -1 && str_contains($col, 'pengesahan pembetulan dari pemeriksa')) $map['endorsement_from_examiner_date'] = $index;
            elseif ($map['abstract_received_date'] === -1 && str_contains($col, 'abstrak')) $map['abstract_received_date'] = $index;
            elseif ($map['final_result'] === -1 && str_contains($col, 'keputusan akhir')) $map['final_result'] = $index;

            // 6. Graduation
            elseif ($map['gais_keyin_date'] === -1 && str_contains($col, 'gais')) $map['gais_keyin_date'] = $index;
            elseif ($map['senate_meeting_date'] === -1 && str_contains($col, 'kemasukan ke senat')) $map['senate_meeting_date'] = $index;
            elseif ($map['senate_status'] === -1 && str_contains($col, 'keputusan senat')) $map['senate_status'] = $index;
            elseif ($map['thesis_certification_date'] === -1 && str_contains($col, 'perakuan tesis')) $map['thesis_certification_date'] = $index;
            elseif ($map['final_thesis_form_date'] === -1 && str_contains($col, 'final thesis form')) $map['final_thesis_form_date'] = $index;
            elseif ($map['hard_bound_copies_date'] === -1 && (str_contains($col, 'bound') || str_contains($col, 'hard binding'))) $map['hard_bound_copies_date'] = $index;
            elseif ($map['loose_copy_date'] === -1 && str_contains($col, 'loose copy')) $map['loose_copy_date'] = $index;
            elseif ($map['cd_copies_date'] === -1 && str_contains($col, 'cd')) $map['cd_copies_date'] = $index;
            elseif ($map['etd_form_date'] === -1 && str_contains($col, 'etd form')) $map['etd_form_date'] = $index;
            elseif ($map['sent_to_psb_date'] === -1 && str_contains($col, 'hantar ke psb')) $map['sent_to_psb_date'] = $index;
            elseif ($map['graduation_date'] === -1 && str_contains($col, 'tarikh graduasi')) $map['graduation_date'] = $index;
        }

        return $map;
    }

    private function processSupervisors(int $studentId, array $row, array $map): void
    {
        $this->supervisorModel->removeAllFromStudent($studentId);

        $supervisors = [
            ['name' => $this->getVal($row, $map['supervisor_1']), 'role' => 'main'],
            ['name' => $this->getVal($row, $map['supervisor_2']), 'role' => 'co'],
            ['name' => $this->getVal($row, $map['supervisor_3']), 'role' => 'co']
        ];

        foreach ($supervisors as $sup) {
            if (empty($sup['name'])) continue;
            
            $existing = $this->supervisorModel->findByName($sup['name']);
            if ($existing) {
                $supId = $existing['supervisor_id'];
            } else {
                $supId = $this->supervisorModel->create([
                    'supervisor_name' => $sup['name'],
                    'email' => null,
                    'department' => null
                ]);
            }

            $this->supervisorModel->assignToStudent($studentId, $supId, $sup['role']);
        }
    }

    private function processViva(int $studentId, array $row, array $map): void
    {
        $internalId = $this->getOrCreateExaminer($this->getVal($row, $map['internal_examiner_name']));
        $externalId = $this->getOrCreateExaminer($this->getVal($row, $map['external_examiner_name']));

        $vivaData = [
            'internal_examiner_id' => $internalId,
            'external_examiner_id' => $externalId,
            'chairperson_name' => $this->getVal($row, $map['chairperson_name']),
            'thesis_submission_email_date' => $this->getDateVal($row, $map['thesis_submission_email_date']),
            'draft_hard_copy_date' => $this->getDateVal($row, $map['draft_hard_copy_date']),
            'draft_soft_copy_date' => $this->getDateVal($row, $map['draft_soft_copy_date']),
            'turnitin_percentage' => $this->getVal($row, $map['turnitin_percentage']),
            'draft_submission_form_date' => $this->getDateVal($row, $map['draft_submission_form_date']),
            'internal_examiner_email_date' => $this->getDateVal($row, $map['internal_examiner_email_date']),
            'external_examiner_email_date' => $this->getDateVal($row, $map['external_examiner_email_date']),
            'panel_appointment_letter_date' => $this->getDateVal($row, $map['panel_appointment_letter_date']),
            'thesis_to_panel_hard_copy_date' => $this->getDateVal($row, $map['thesis_to_panel_hard_copy_date']),
            'thesis_to_panel_soft_copy_date' => $this->getDateVal($row, $map['thesis_to_panel_soft_copy_date']),
            'confirm_date_email_date' => $this->getDateVal($row, $map['confirm_date_email_date']),
            'invitation_letter_date' => $this->getDateVal($row, $map['invitation_letter_date']),
            'viva_date' => $this->getDateVal($row, $map['viva_date']),
            'viva_result' => $this->getVal($row, $map['viva_result']),
            'internal_examiner_report_date' => $this->getDateVal($row, $map['internal_examiner_report_date']),
            'best_thesis_candidate' => in_array(
                strtolower(trim((string)($this->getVal($row, $map['best_thesis_candidate']) ?? ''))),
                ['yes', 'ya', '1', 'true', '✓', 'iya', 'y']
            ) ? 1 : 0, // M4: Use explicit allowlist instead of PHP truthiness (avoids "0" string = false edge-case)
            'honorarium_chairperson' => $this->getVal($row, $map['honorarium_chairperson']),
            'honorarium_internal' => $this->getVal($row, $map['honorarium_internal']),
            'honorarium_external' => $this->getVal($row, $map['honorarium_external']),
            'honorarium_refreshment' => $this->getVal($row, $map['honorarium_refreshment'])
        ];

        // Fallback: construct viva_date from separate HARI/BULAN/TAHUN columns if the combined date is empty.
        if (empty($vivaData['viva_date'])) {
            $hari  = $this->getVal($row, $map['viva_hari']);
            $bulan = $this->getVal($row, $map['viva_bulan']);
            $tahun = $this->getVal($row, $map['viva_tahun']);

            if (!empty($tahun) && !empty($bulan) && !empty($hari)) {
                $vivaData['viva_date'] = sprintf('%04d-%02d-%02d', (int)$tahun, (int)$bulan, (int)$hari);
            } elseif (!empty($tahun) && !empty($bulan)) {
                // If only year and month are available, default day to 1.
                $vivaData['viva_date'] = sprintf('%04d-%02d-01', (int)$tahun, (int)$bulan);
            }
        }

        $this->vivaModel->createOrUpdate($studentId, $vivaData);
    }

    private function processCorrections(int $studentId, array $row, array $map): void
    {
        $corrData = [
            'correction_deadline' => $this->getDateVal($row, $map['correction_deadline']),
            'reviewed_by' => $this->getVal($row, $map['reviewed_by']),
            'report_sent_to_student_date' => $this->getDateVal($row, $map['report_sent_to_student_date']),
            'internal_report_status' => $this->getVal($row, $map['internal_report_status']),
            'external_report_status' => $this->getVal($row, $map['external_report_status']),
            'corrected_thesis_received_date' => $this->getDateVal($row, $map['corrected_thesis_received_date']),
            'checklist_after_viva_date' => $this->getDateVal($row, $map['checklist_after_viva_date']),
            'correction_schedule_date' => $this->getDateVal($row, $map['correction_schedule_date']),
            'post_viva_turnitin_percentage' => $this->getVal($row, $map['post_viva_turnitin_percentage']),
            'supervisor_endorsement_date' => $this->getDateVal($row, $map['supervisor_endorsement_date']),
            'sent_to_internal_date' => $this->getDateVal($row, $map['sent_to_internal_date']),
            'sent_to_external_date' => $this->getDateVal($row, $map['sent_to_external_date']),
            'sent_to_supervisor_date' => $this->getDateVal($row, $map['sent_to_supervisor_date']),
            'endorsement_from_examiner_date' => $this->getDateVal($row, $map['endorsement_from_examiner_date']),
            'abstract_received_date' => $this->getDateVal($row, $map['abstract_received_date']),
            'final_result' => $this->getVal($row, $map['final_result'])
        ];
        
        $corrData['correction_required'] = !empty($corrData['correction_deadline']) ? 1 : 0;
        
        if (!empty($corrData['final_result'])) {
            $corrData['verification_status'] = 'Verified';
        } else {
            $corrData['verification_status'] = null; 
        }

        $this->correctionModel->createOrUpdate($studentId, $corrData);
    }

    private function processGraduation(int $studentId, array $row, array $map): void
    {
        $gradData = [
            'gais_keyin_date' => $this->getDateVal($row, $map['gais_keyin_date']),
            'jil_meeting_date' => $this->getDateVal($row, $map['jil_meeting_date']),
            'senate_meeting_date' => $this->getDateVal($row, $map['senate_meeting_date']),
            'senate_status' => $this->getVal($row, $map['senate_status']),
            'thesis_certification_date' => $this->getDateVal($row, $map['thesis_certification_date']),
            'final_thesis_form_date' => $this->getDateVal($row, $map['final_thesis_form_date']),
            'hard_bound_copies_date' => $this->getDateVal($row, $map['hard_bound_copies_date']),
            'loose_copy_date' => $this->getDateVal($row, $map['loose_copy_date']),
            'cd_copies_date' => $this->getDateVal($row, $map['cd_copies_date']),
            'etd_form_date' => $this->getDateVal($row, $map['etd_form_date']),
            'sent_to_psb_date' => $this->getDateVal($row, $map['sent_to_psb_date']),
            'graduation_date' => $this->getDateVal($row, $map['graduation_date'])
        ];

        $gradData['graduation_status'] = !empty($gradData['graduation_date']) ? 'Graduated' : 'Not Ready';
        
        if (!empty($gradData['jil_meeting_date'])) $gradData['jil_status'] = 'Approved';
        if (strtolower((string)$gradData['senate_status']) === 'lulus') $gradData['senate_status'] = 'Approved';

        $this->graduationModel->createOrUpdate($studentId, $gradData);
    }

    private function getOrCreateExaminer(?string $name): ?int
    {
        if (empty($name) || $name === '-') return null;
        
        $parts = explode('/', $name);
        $cleanName = trim($parts[0]);
        $cleanName = explode("\n", $cleanName)[0];
        $cleanName = trim($cleanName);

        if (empty($cleanName)) return null;

        $existing = $this->examinerModel->findByName($cleanName);
        if ($existing) {
            return $existing['examiner_id'];
        }

        return $this->examinerModel->create([
            'examiner_name' => $cleanName,
            'institution' => null,
            'email' => null,
            'phone' => null
        ]);
    }
}
