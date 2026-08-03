<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Student;
use App\Services\DocxTemplateEngine;
use Exception;

class DocxTemplateController extends Controller
{
    private Student $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    /**
     * Display Docx Templates generator page
     */
    public function index(): void
    {
        Middleware::requireLogin();

        $students = $this->studentModel->getAll();
        
        // Scan templates directory
        $templateDir = dirname(__DIR__, 2) . '/storage/templates';
        if (!is_dir($templateDir)) {
            mkdir($templateDir, 0755, true);
        }

        $templateFiles = glob($templateDir . '/*.docx') ?: [];
        $templates = array_map(function ($file) {
            return [
                'filename' => basename($file),
                'name'     => str_replace(['_', '-'], ' ', pathinfo($file, PATHINFO_FILENAME)),
                'path'     => $file,
                'size'     => round(filesize($file) / 1024, 1) . ' KB'
            ];
        }, $templateFiles);

        $selectedStudentId = $_GET['student_id'] ?? null;
        $selectedStudent = null;
        if ($selectedStudentId) {
            $selectedStudent = $this->studentModel->getFullDetails((int)$selectedStudentId);
        }

        $data = [
            'pageTitle'       => 'Docx Template Generator',
            'currentPage'     => 'docx_templates',
            'students'        => $students,
            'templates'       => $templates,
            'selectedStudent' => $selectedStudent
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('docx_templates.index', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * Process template and download populated .docx file
     */
    public function generate(): void
    {
        Middleware::requireLogin();

        // H1: Validate CSRF token — prevents forged cross-site document generation.
        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid security token. Please try again.');
            $this->redirect($this->baseUrl() . '/docx-templates');
            return;
        }

        $studentId = (int)$this->input('student_id', 0);
        $templateFilename = trim($this->input('template_filename', 'perakuan_kerja_tesis.docx'));
        if (str_ends_with(strtolower($templateFilename), '.doc') && !str_ends_with(strtolower($templateFilename), '.docx')) {
            $templateFilename .= 'x';
        }

        if (!$studentId) {
            $this->setFlash('danger', 'Please select a student to generate the document.');
            $this->redirect($this->baseUrl() . '/docx-templates');
            return;
        }

        $student = $this->studentModel->getFullDetails($studentId);
        if (!$student) {
            $this->setFlash('danger', 'Selected student not found.');
            $this->redirect($this->baseUrl() . '/docx-templates');
            return;
        }

        $templatePath = dirname(__DIR__, 2) . '/storage/templates/' . basename($templateFilename);
        if (!file_exists($templatePath)) {
            $this->setFlash('danger', 'Selected template file does not exist.');
            $this->redirect($this->baseUrl() . '/docx-templates');
            return;
        }

        // Build placeholder data array
        $viva = $student['viva_records'][0] ?? [];
        $corr = $student['correction'] ?? [];
        $grad = $student['graduation'] ?? [];

        $mainSupervisors = [];
        $coSupervisors = [];
        if (!empty($student['supervisors'])) {
            foreach ($student['supervisors'] as $s) {
                if ($s['role'] === 'main') {
                    $mainSupervisors[] = $s['supervisor_name'];
                } else {
                    $coSupervisors[] = $s['supervisor_name'];
                }
            }
        }

        $placeholderData = [
            'STUDENT_NAME'                  => $student['name'] ?? '',
            'NAME'                          => $student['name'] ?? '',
            'MATRIC_NO'                     => $student['matric_no'] ?? '',
            'MATRIC'                        => $student['matric_no'] ?? '',
            'PROGRAMME'                     => $student['programme'] ?? '',
            'SCHOOL'                        => $student['school'] ?? '',
            'DEGREE_LEVEL'                  => $student['degree_level'] ?? '',
            'COHORT'                        => $student['cohort'] ?? '',
            'ITS_RECEIPT_DATE'              => $student['its_receipt_date'] ?? '',
            'THESIS_TITLE'                  => $student['thesis_title'] ?? '',
            'RESEARCH_STATUS'               => $student['research_status'] ?? '',
            
            // Supervisors & Panel
            'MAIN_SUPERVISORS'              => implode(', ', $mainSupervisors),
            'CO_SUPERVISORS'                => implode(', ', $coSupervisors),
            'SUPERVISORS'                   => implode(', ', array_merge($mainSupervisors, $coSupervisors)),
            'CHAIRPERSON_NAME'              => $viva['chairperson_name'] ?? '',
            'INTERNAL_EXAMINER'             => $viva['examiner_name'] ?? '',
            'EXTERNAL_EXAMINER'             => $viva['external_examiner_name'] ?? '',

            // Viva & Dates
            'VIVA_DATE'                     => !empty($viva['viva_date']) ? strtoupper(date('d M Y', strtotime($viva['viva_date']))) : '',
            'VIVA_RESULT'                   => $viva['viva_result'] ?? '',
            'TURNITIN_PERCENTAGE'           => $viva['turnitin_percentage'] ?? '',
            'CORRECTION_DEADLINE'           => $corr['correction_deadline'] ?? '',
            'GRADUATION_DATE'               => $grad['graduation_date'] ?? '',
            
            // System meta
            'TODAY_DATE'                    => date('d/m/Y'),
            'SYSTEM_DATE'                   => date('Y-m-d H:i:s')
        ];

        try {
            $binaryContent = DocxTemplateEngine::process($templatePath, $placeholderData);

            $downloadName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student['matric_no'] . '_' . $student['name']) . '_' . pathinfo($templateFilename, PATHINFO_FILENAME) . '.docx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . $downloadName . '"');
            // M5: Use mb_strlen with '8bit' to get raw byte count, safe with mbstring overloading.
            header('Content-Length: ' . mb_strlen($binaryContent, '8bit'));
            header('Cache-Control: max-age=0');

            echo $binaryContent;
            exit;
        } catch (Exception $e) {
            $this->setFlash('danger', 'Failed to generate document: ' . $e->getMessage());
            $this->redirect($this->baseUrl() . '/docx-templates');
        }
    }
}
