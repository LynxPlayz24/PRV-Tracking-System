<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Student;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    private Student $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    /**
     * Show export page with student list
     */
    public function index(): void
    {
        Middleware::requireLogin();

        $students = $this->studentModel->getAll();

        $data = [
            'pageTitle'   => 'Export Data',
            'currentPage' => 'export',
            'students'    => $students
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('export.index', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * Generate PDF for a single student
     */
    public function exportSinglePdf(string $id): void
    {
        Middleware::requireLogin();

        $studentId = (int)$id;
        $student = $this->studentModel->getFullDetails($studentId);

        if (!$student) {
            $this->setFlash('danger', 'Student not found.');
            $this->redirect($this->baseUrl() . '/search');
            return;
        }

        // Configure DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // allow remote images if any
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new Dompdf($options);

        // Load the HTML template
        ob_start();
        $this->view('export.pdf_template', ['student' => $student]);
        $html = ob_get_clean();

        // Load HTML into DomPDF
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output to browser
        $filename = 'PRVTS_Report_' . $student['matric_no'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
    }

    /**
     * Generate Excel for a single student
     */
    public function exportSingleExcel(string $id): void
    {
        Middleware::requireLogin();

        $studentId = (int)$id;
        $student = $this->studentModel->getFullDetails($studentId);

        if (!$student) {
            $this->setFlash('danger', 'Student not found.');
            $this->redirect($this->baseUrl() . '/search');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Student Report');

        // Styles
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF003399']]
        ];
        $labelStyle = ['font' => ['bold' => true]];

        $row = 1;

        // Function to add a section header
        $addHeader = function($title) use (&$sheet, &$row, $headerStyle) {
            $row++;
            $sheet->setCellValue('A' . $row, $title);
            $sheet->mergeCells('A' . $row . ':B' . $row);
            $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($headerStyle);
            $row++;
        };

        // Function to add a data row
        $addRow = function($label, $value) use (&$sheet, &$row, $labelStyle) {
            $sheet->setCellValue('A' . $row, $label);
            $sheet->getStyle('A' . $row)->applyFromArray($labelStyle);
            
            // Format dates simply if it looks like YYYY-MM-DD
            if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $value = date('d M Y', strtotime($value));
            }
            
            $sheet->setCellValue('B' . $row, $value ?? '-');
            $row++;
        };

        // Title
        $sheet->setCellValue('A1', 'PRVTS Student Report: ' . $student['name']);
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        
        // Data Extraction
        $viva = $student['viva_records'][0] ?? [];
        $corr = $student['correction'] ?? [];
        $grad = $student['graduation'] ?? [];

        // 1. Personal & Academic
        $addHeader('Personal & Academic Information');
        $addRow('Name', $student['name']);
        $addRow('Matric No', $student['matric_no']);
        $addRow('Programme', $student['programme']);
        $addRow('School', $student['school']);
        $addRow('Degree Level', $student['degree_level']);
        $addRow('Research Status', $student['research_status']);

        // 2. Research Information
        $addHeader('Research Information');
        $addRow('Thesis Title', $student['thesis_title']);
        
        $mainSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'main');
        $coSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'co');
        
        $addRow('Main Supervisor(s)', implode(", ", array_column($mainSups, 'supervisor_name')));
        $addRow('Co-Supervisor(s)', implode(", ", array_column($coSups, 'supervisor_name')));
        
        $addRow('Registration Date', $grad['registration_date'] ?? null);
        $addRow('No of Semesters', $grad['no_of_semesters'] ?? null);
        $addRow('End of Study Date', $grad['end_of_study_date'] ?? null);
        $addRow('Title Proposal Defence Date', $grad['title_proposal_defence_date'] ?? null);
        $addRow('JIL Meeting No', $grad['jil_meeting_no'] ?? null);

        // 3. Draft Thesis Requirements
        $addHeader('Draft Thesis Requirements');
        $addRow('Notice of Submission Date', $viva['notice_of_submission_date'] ?? null);
        $addRow('Turnitin Report Date', $viva['turnitin_report_date'] ?? null);
        $addRow('Turnitin Percentage (%)', $viva['turnitin_percentage'] ?? null);
        $addRow('Draft Submission Form Date', $viva['draft_submission_form_date'] ?? null);

        // 4. Examination Panel & Viva
        $addHeader('Examination Panel');
        $addRow('Internal Examiner(s)', implode(", ", array_column(array_filter($student['examiners'] ?? [], fn($e) => $e['role'] === 'internal'), 'examiner_name')));
        $addRow('External Examiner(s)', implode(", ", array_column(array_filter($student['examiners'] ?? [], fn($e) => $e['role'] === 'external'), 'examiner_name')));

        $addHeader('Panel Arrangement Dates');
        $addRow('Senate Endorsement Date', $viva['senate_endorsement_date'] ?? null);
        $addRow('Appointment Letter Date', $viva['appointment_letter_date'] ?? null);
        $addRow('Thesis Handed to Panel Date', $viva['thesis_handed_to_panel_date'] ?? null);
        
        $addHeader('Viva-Voce');
        $addRow('Invitation Letter Date', $viva['invitation_letter_date'] ?? null);
        $addRow('Viva Date', $viva['viva_date'] ?? null);
        $addRow('Chairperson Name', $viva['chairperson_name'] ?? null);
        $addRow('Internal Examiner Report Date', $viva['internal_examiner_report_date'] ?? null);
        $addRow('External Examiner Report Date', $viva['external_examiner_report_date'] ?? null);
        $addRow('Viva Result', $viva['viva_result'] ?? null);
        $addRow('Best Thesis Candidate', !empty($viva['best_thesis_candidate']) ? 'Yes' : 'No');

        // 5. Post-Viva Corrections
        $addHeader('Post-Viva Corrections & Submission');
        $addRow('Correction Deadline', $corr['correction_deadline'] ?? null);
        $addRow('Internal Report Status', $corr['internal_report_status'] ?? null);
        $addRow('External Report Status', $corr['external_report_status'] ?? null);
        
        $addHeader('Corrected Thesis Tracking');
        $addRow('Corrected Thesis Received Date', $corr['corrected_thesis_received_date'] ?? null);
        $addRow('Checklist After Viva Date', $corr['checklist_after_viva_date'] ?? null);
        $addRow('Correction Schedule Date', $corr['correction_schedule_date'] ?? null);
        $addRow('Post-Viva Turnitin (%)', $corr['post_viva_turnitin_percentage'] ?? null);
        $addRow('Supervisor Endorsement Date', $corr['supervisor_endorsement_date'] ?? null);
        $addRow('Sent to Internal Date', $corr['sent_to_internal_date'] ?? null);
        $addRow('Sent to External Date', $corr['sent_to_external_date'] ?? null);
        $addRow('Sent to Supervisor Date', $corr['sent_to_supervisor_date'] ?? null);
        $addRow('Endorsement from Examiner Date', $corr['endorsement_from_examiner_date'] ?? null);
        $addRow('Abstract Received Date', $corr['abstract_received_date'] ?? null);
        $addRow('Final Result', $corr['final_result'] ?? null);

        // 6. Honorarium
        $addHeader('Honorarium Details');
        $addRow('Chairperson', $viva['honorarium_chairperson'] ?? null);
        $addRow('Internal Examiner', $viva['honorarium_internal'] ?? null);
        $addRow('External Examiner', $viva['honorarium_external'] ?? null);
        $addRow('Refreshment', $viva['honorarium_refreshment'] ?? null);

        // 7. Graduation & Approvals
        $addHeader('Institutional Approvals & Graduation');
        $addRow('GAIS Key-in Date', $grad['gais_keyin_date'] ?? null);
        $addRow('Senate Meeting Date', $grad['senate_meeting_date'] ?? null);
        $addRow('Senate Meeting No.', $grad['senate_meeting_no'] ?? null);
        $addRow('Senate Status', $grad['senate_status'] ?? null);
        $addRow('Thesis Certification Date', $grad['thesis_certification_date'] ?? null);
        
        $addHeader('Final Document Submissions');
        $addRow('Final Thesis Form Date', $grad['final_thesis_form_date'] ?? null);
        $addRow('Hard Bound Copies Date', $grad['hard_bound_copies_date'] ?? null);
        $addRow('Loose Copy Date', $grad['loose_copy_date'] ?? null);
        $addRow('CD Copies Date', $grad['cd_copies_date'] ?? null);
        $addRow('ETD Form Date', $grad['etd_form_date'] ?? null);
        $addRow('Sent to PSB Date', $grad['sent_to_psb_date'] ?? null);
        
        $addRow('Graduation Date', $grad['graduation_date'] ?? null);

        // Auto-size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'PRVTS_Report_' . $student['matric_no'] . '.xlsx';
        
        // Clean output buffer before sending headers
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate bulk PDF for all students
     */
    public function exportPdf(): void
    {
        Middleware::requireLogin();

        $students = $this->studentModel->getAll();

        if (empty($students)) {
            $this->setFlash('warning', 'No students available to export.');
            $this->redirect($this->baseUrl() . '/export');
            return;
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new Dompdf($options);

        ob_start();
        foreach ($students as $index => $basicStudent) {
            $student = $this->studentModel->getFullDetails((int)$basicStudent['student_id']);
            if ($student) {
                $this->view('export.pdf_template', ['student' => $student]);
                if ($index < count($students) - 1) {
                    echo '<div style="page-break-after: always;"></div>';
                }
            }
        }
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'PRVTS_Bulk_Report_' . date('Ymd_His') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
    }

    /**
     * Generate bulk Excel for all students
     */
    public function exportExcel(): void
    {
        Middleware::requireLogin();

        $students = $this->studentModel->getAll();

        if (empty($students)) {
            $this->setFlash('warning', 'No students available to export.');
            $this->redirect($this->baseUrl() . '/export');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('All Students Summary');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF003399']]
        ];

        // Headers
        $headers = [
            'A1' => 'Matric No',
            'B1' => 'Name',
            'C1' => 'Programme',
            'D1' => 'School',
            'E1' => 'Degree Level',
            'F1' => 'Status',
            'G1' => 'Main Supervisor',
            'H1' => 'Viva Date',
            'I1' => 'Viva Result',
            'J1' => 'Graduation Date'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($students as $basicStudent) {
            $student = $this->studentModel->getFullDetails((int)$basicStudent['student_id']);
            if (!$student) continue;

            $viva = $student['viva_records'][0] ?? [];
            $grad = $student['graduation'] ?? [];
            $mainSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'main');
            
            $vivaDate = (!empty($viva['viva_date'])) ? date('d M Y', strtotime($viva['viva_date'])) : '-';
            $gradDate = (!empty($grad['graduation_date'])) ? date('d M Y', strtotime($grad['graduation_date'])) : '-';

            $sheet->setCellValue('A' . $row, $student['matric_no']);
            $sheet->setCellValue('B' . $row, $student['name']);
            $sheet->setCellValue('C' . $row, $student['programme'] ?? '-');
            $sheet->setCellValue('D' . $row, $student['school'] ?? '-');
            $sheet->setCellValue('E' . $row, $student['degree_level']);
            $sheet->setCellValue('F' . $row, $student['research_status']);
            $sheet->setCellValue('G' . $row, implode(", ", array_column($mainSups, 'supervisor_name')) ?: '-');
            $sheet->setCellValue('H' . $row, $vivaDate);
            $sheet->setCellValue('I' . $row, $viva['viva_result'] ?? '-');
            $sheet->setCellValue('J' . $row, $gradDate);
            
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'PRVTS_Bulk_Summary_' . date('Ymd_His') . '.xlsx';
        
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
