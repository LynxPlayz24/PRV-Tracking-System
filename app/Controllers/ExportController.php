<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Student;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportController extends Controller
{
    private Student $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    /**
     * Show export page with filtered student list
     */
    public function index(): void
    {
        Middleware::requireLogin();

        $filters = [
            'month'           => trim($_GET['month'] ?? ''),
            'year'            => trim($_GET['year'] ?? ''),
            'school'          => trim($_GET['school'] ?? ''),
            'degree_level'    => trim($_GET['degree_level'] ?? ''),
            'research_status' => trim($_GET['research_status'] ?? ''),
            'sort_viva'       => trim($_GET['sort_viva'] ?? ''),
        ];

        $students  = $this->studentModel->getFiltered($filters);
        $schools   = $this->studentModel->getSchools();
        $vivaYears = $this->studentModel->getVivaYears();

        $data = [
            'pageTitle'   => 'Export Data',
            'currentPage' => 'export',
            'students'    => $students,
            'schools'     => $schools,
            'vivaYears'   => $vivaYears,
            'filters'     => $filters
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

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new Dompdf($options);

        ob_start();
        $this->view('export.pdf_template', ['student' => $student]);
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'PRVTS_' . $student['matric_no'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
    }

    /**
     * Generate Modern Excel for a single student
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
        $sheet->setTitle('Student Detail Report');

        // Professional Color Palette
        $navyBanner = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER]
        ];

        $sectionHeader = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ];

        $labelStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FF334155']],
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE2E8F0']]]
        ];

        $valueStyle = [
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE2E8F0']]]
        ];

        // Title Banner
        $sheet->setCellValue('A1', ' PRVTS RECORD: ' . strtoupper($student['name']) . ' (' . $student['matric_no'] . ')');
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1:B1')->applyFromArray($navyBanner);
        $sheet->getRowDimension(1)->setRowHeight(35);

        $row = 3;

        $addHeader = function($title) use (&$sheet, &$row, $sectionHeader) {
            $sheet->setCellValue('A' . $row, ' ' . $title);
            $sheet->mergeCells('A' . $row . ':B' . $row);
            $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($sectionHeader);
            $sheet->getRowDimension($row)->setRowHeight(24);
            $row++;
        };

        $addRow = function($label, $value) use (&$sheet, &$row, $labelStyle, $valueStyle) {
            $sheet->setCellValue('A' . $row, $label);
            $sheet->getStyle('A' . $row)->applyFromArray($labelStyle);
            
            if ($value && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $value = date('d M Y', strtotime($value));
            }
            
            $sheet->setCellValue('B' . $row, $value ?? '-');
            $sheet->getStyle('B' . $row)->applyFromArray($valueStyle);
            $sheet->getRowDimension($row)->setRowHeight(20);
            $row++;
        };

        // Data Extraction
        $viva = $student['viva_records'][0] ?? [];
        $corr = $student['correction'] ?? [];
        $grad = $student['graduation'] ?? [];

        // 1. Personal & Academic
        $addHeader('1. Personal & Academic Information');
        $addRow('Name', $student['name']);
        $addRow('Matric No', $student['matric_no']);
        $addRow('Programme', $student['programme']);
        $addRow('School', $student['school']);
        $addRow('Degree Level', $student['degree_level']);
        $addRow('Research Status', $student['research_status']);
        $row++;

        // 2. Research Information
        $addHeader('2. Research Information');
        $addRow('Thesis Title', $student['thesis_title']);
        
        $mainSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'main');
        $coSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'co');
        
        $addRow('Main Supervisor(s)', implode(", ", array_column($mainSups, 'supervisor_name')));
        $addRow('Co-Supervisor(s)', implode(", ", array_column($coSups, 'supervisor_name')));
        $row++;

        // 3. Draft Thesis Requirements
        $addHeader('3. Draft Thesis Requirements');
        $addRow('Submission Email Date', $viva['thesis_submission_email_date'] ?? null);
        $addRow('Draft 4 Hard Copy Date', $viva['draft_hard_copy_date'] ?? null);
        $addRow('Soft Copy Date', $viva['draft_soft_copy_date'] ?? null);
        $addRow('Turnitin Percentage (%)', $viva['turnitin_percentage'] ?? null);
        $addRow('Draft Submission Form Date', $viva['draft_submission_form_date'] ?? null);
        $row++;

        // 4. Examination Panel & Viva
        $addHeader('4. Examination Panel & Viva-Voce');
        $addRow('Chairperson Name', $viva['chairperson_name'] ?? null);
        $addRow('Internal Examiner', $viva['examiner_name'] ?? null);
        $addRow('External Examiner', $viva['external_examiner_name'] ?? null);
        $addRow('Viva Date', $viva['viva_date'] ?? null);
        $addRow('Viva Result', $viva['viva_result'] ?? null);
        $addRow('Best Thesis Candidate', !empty($viva['best_thesis_candidate']) ? 'Yes' : 'No');
        $row++;

        // 5. Post-Viva Corrections
        $addHeader('5. Post-Viva Corrections');
        $addRow('Correction Deadline', $corr['correction_deadline'] ?? null);
        $addRow('Corrected Thesis Received Date', $corr['corrected_thesis_received_date'] ?? null);
        $addRow('Final Result', $corr['final_result'] ?? null);
        $row++;

        // 6. Honorarium Details
        $formatMoney = function($val) {
            if ($val === null || $val === '' || $val === false) return '-';
            $clean = trim((string)$val);
            if (is_numeric($clean)) {
                return 'RM ' . number_format((float)$clean, 2);
            }
            return str_starts_with(strtoupper($clean), 'RM') ? $clean : 'RM ' . $clean;
        };

        $addHeader('6. Honorarium Details');
        $addRow('Chairperson Honorarium', $formatMoney($viva['honorarium_chairperson'] ?? null));
        $addRow('Internal Examiner Honorarium', $formatMoney($viva['honorarium_internal'] ?? null));
        $addRow('External Examiner Honorarium', $formatMoney($viva['honorarium_external'] ?? null));
        $addRow('Refreshment Honorarium', $formatMoney($viva['honorarium_refreshment'] ?? null));
        $row++;

        // 7. Graduation & Approvals
        $addHeader('7. Institutional Approvals & Graduation');
        $addRow('Senate Status', $grad['senate_status'] ?? null);
        $addRow('Graduation Date', $grad['graduation_date'] ?? null);

        // Auto-size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'PRVTS_' . $student['matric_no'] . '.xlsx';
        
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
     * Generate bulk PDF for filtered students
     */
    public function exportPdf(): void
    {
        Middleware::requireLogin();

        $filters = [
            'month'           => trim($this->input('month', '')),
            'year'            => trim($this->input('year', '')),
            'school'          => trim($this->input('school', '')),
            'degree_level'    => trim($this->input('degree_level', '')),
            'research_status' => trim($this->input('research_status', '')),
            'sort_viva'       => trim($this->input('sort_viva', '')),
        ];

        $basicStudents = $this->studentModel->getFiltered($filters);

        if (empty($basicStudents)) {
            $this->setFlash('warning', 'No students match your criteria to export.');
            $this->redirect($this->baseUrl() . '/export');
            return;
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new Dompdf($options);

        ob_start();
        foreach ($basicStudents as $index => $basicStudent) {
            $student = $this->studentModel->getFullDetails((int)$basicStudent['student_id']);
            if ($student) {
                $this->view('export.pdf_template', ['student' => $student]);
                if ($index < count($basicStudents) - 1) {
                    echo '<div style="page-break-after: always;"></div>';
                }
            }
        }
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'PRVTS_Bulk_' . date('Ymd_His') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
    }

    /**
     * Generate Modern Bulk Excel Export with Multi-Parameter Filtering & Viva Month Sorting
     */
    public function exportExcel(): void
    {
        Middleware::requireLogin();

        $filters = [
            'month'           => trim($this->input('month', '')),
            'year'            => trim($this->input('year', '')),
            'school'          => trim($this->input('school', '')),
            'degree_level'    => trim($this->input('degree_level', '')),
            'research_status' => trim($this->input('research_status', '')),
            'sort_viva'       => trim($this->input('sort_viva', '')),
        ];

        $basicStudents = $this->studentModel->getFiltered($filters);

        if (empty($basicStudents)) {
            $this->setFlash('warning', 'No students match your filter criteria for Excel export.');
            $this->redirect($this->baseUrl() . '/export');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('PRVTS Students Summary');

        // Styles & Branding Palette
        $titleBannerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0F172A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ];

        $metricCardLabel = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FF475569'], 'size' => 9],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF1F5F9']]
        ];

        $metricCardVal = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FF1E293B'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF1F5F9']]
        ];

        $tableHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ];

        $thinBorder = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE2E8F0']]
            ]
        ];

        // 1. Header Banner
        $sheet->setCellValue('A1', 'POSTGRADUATE RESEARCH & VIVA TRACKING SYSTEM (PRVTS)');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1:J1')->applyFromArray($titleBannerStyle);
        $sheet->getRowDimension(1)->setRowHeight(36);

        // 2. Metric Cards Block
        $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $selectedMonth = !empty($filters['month']) ? ($monthNames[(int)$filters['month']] ?? 'All') : 'All Months';
        $selectedSchool = !empty($filters['school']) ? $filters['school'] : 'All Schools';

        $sheet->setCellValue('A3', 'TOTAL RECORDS');
        $sheet->setCellValue('A4', count($basicStudents) . ' Students');
        $sheet->getStyle('A3')->applyFromArray($metricCardLabel);
        $sheet->getStyle('A4')->applyFromArray($metricCardVal);

        $sheet->setCellValue('D3', 'FILTERED SCHOOL');
        $sheet->setCellValue('D4', $selectedSchool);
        $sheet->getStyle('D3')->applyFromArray($metricCardLabel);
        $sheet->getStyle('D4')->applyFromArray($metricCardVal);

        $sheet->setCellValue('G3', 'VIVA MONTH FILTER');
        $sheet->setCellValue('G4', $selectedMonth);
        $sheet->getStyle('G3')->applyFromArray($metricCardLabel);
        $sheet->getStyle('G4')->applyFromArray($metricCardVal);

        $sheet->setCellValue('J3', 'GENERATED DATE');
        $sheet->setCellValue('J4', date('d M Y'));
        $sheet->getStyle('J3')->applyFromArray($metricCardLabel);
        $sheet->getStyle('J4')->applyFromArray($metricCardVal);

        // 3. Table Column Headers
        $headers = [
            'A6' => 'Matric No',
            'B6' => 'Student Name',
            'C6' => 'Programme',
            'D6' => 'School',
            'E6' => 'Degree Level',
            'F6' => 'Research Status',
            'G6' => 'Main Supervisor',
            'H6' => 'Viva Date',
            'I6' => 'Viva Result',
            'J6' => 'Graduation Date'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }
        $sheet->getStyle('A6:J6')->applyFromArray($tableHeaderStyle);
        $sheet->getRowDimension(6)->setRowHeight(26);

        // 4. Data Rows
        $row = 7;
        foreach ($basicStudents as $basicStudent) {
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

            // Apply borders & row dimension
            $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray($thinBorder);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Zebra shading for even rows
            if ($row % 2 === 0) {
                $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF8FAFC');
            }

            $sheet->getRowDimension($row)->setRowHeight(22);
            $row++;
        }

        // Auto-size columns A through J
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
