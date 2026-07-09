<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware;

/**
 * DashboardController renders the admin dashboard and computes statistics.
 */
class DashboardController extends Controller
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Show dashboard page
     */
    public function index(): void
    {
        Middleware::requireAdmin();

        $data = [
            'pageTitle'    => 'Dashboard',
            'currentPage'  => 'dashboard',
            'stats'        => $this->getStats(),
            'actions'      => $this->getActionRequired(),
            'pending'      => $this->getPendingResponses()
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('dashboard.index', $data);
        $this->view('layouts.footer', $data);
    }

    private function getActionRequired(): array
    {
        $actions = [];
        
        // Retrieve students with Vivas scheduled in the next 14 days.
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, v.viva_date 
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.viva_date >= CURDATE() AND v.viva_date <= DATE_ADD(CURDATE(), INTERVAL 14 DAY)
            ORDER BY v.viva_date ASC
            LIMIT 5
        ");
        $vivas = $this->db->resultSet();
        foreach ($vivas as $viva) {
            $actions[] = [
                'student_id' => $viva['student_id'],
                'name' => $viva['name'],
                'matric_no' => $viva['matric_no'],
                'type' => 'Upcoming Viva',
                'date' => $viva['viva_date'],
                'color' => 'primary'
            ];
        }

        // Retrieve corrections that are approaching deadline or overdue.
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, c.correction_deadline 
            FROM students s
            JOIN corrections c ON s.student_id = c.student_id
            WHERE c.correction_deadline IS NOT NULL 
              AND c.correction_deadline < DATE_ADD(CURDATE(), INTERVAL 14 DAY)
              AND c.corrected_thesis_received_date IS NULL
            ORDER BY c.correction_deadline ASC
            LIMIT 5
        ");
        $corrections = $this->db->resultSet();
        foreach ($corrections as $corr) {
            $isOverdue = (strtotime($corr['correction_deadline']) < time());
            $actions[] = [
                'student_id' => $corr['student_id'],
                'name' => $corr['name'],
                'matric_no' => $corr['matric_no'],
                'type' => $isOverdue ? 'Overdue Correction' : 'Correction Due Soon',
                'date' => $corr['correction_deadline'],
                'color' => $isOverdue ? 'danger' : 'warning'
            ];
        }
        
        return $actions;
    }

    private function getPendingResponses(): array
    {
        $pending = [];
        
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, 
                   v.internal_examiner_email_date,
                   v.internal_examiner_report_date
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.internal_examiner_email_date IS NOT NULL 
              AND v.internal_examiner_report_date IS NULL
            ORDER BY v.internal_examiner_email_date ASC
            LIMIT 10
        ");
        $responses = $this->db->resultSet();
        foreach ($responses as $res) {
            $pending[] = [
                'student_id' => $res['student_id'],
                'name' => $res['name'],
                'matric_no' => $res['matric_no'],
                'task' => 'Waiting for Internal Examiner Report',
                'sent_date' => $res['internal_examiner_email_date']
            ];
        }
        
        return $pending;
    }

    private function getStats(): array
    {
        $stats = [
            'total_students'      => 0,
            'pending_viva'        => 0,
            'awaiting_corrections'=> 0,
            'ready_for_senate'    => 0,
            'graduated'           => 0
        ];

        // Total Students
        $this->db->query('SELECT COUNT(*) as cnt FROM students');
        $stats['total_students'] = $this->db->single()['cnt'] ?? 0;

        // Graduated (graduation_date is set)
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            JOIN graduation g ON s.student_id = g.student_id 
            WHERE g.graduation_date IS NOT NULL
        ");
        $stats['graduated'] = $this->db->single()['cnt'] ?? 0;

        // Ready for Senate (final_result exists but not graduated)
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            JOIN corrections c ON s.student_id = c.student_id
            LEFT JOIN graduation g ON s.student_id = g.student_id
            WHERE c.final_result IS NOT NULL AND c.final_result != ''
              AND (g.graduation_date IS NULL)
        ");
        $stats['ready_for_senate'] = $this->db->single()['cnt'] ?? 0;

        // Awaiting Corrections (viva_date passed but no final result yet)
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            JOIN viva_records v ON s.student_id = v.student_id
            LEFT JOIN corrections c ON s.student_id = c.student_id
            LEFT JOIN graduation g ON s.student_id = g.student_id
            WHERE v.viva_date IS NOT NULL AND v.viva_date <= CURDATE()
              AND (c.final_result IS NULL OR c.final_result = '')
              AND (g.graduation_date IS NULL)
        ");
        $stats['awaiting_corrections'] = $this->db->single()['cnt'] ?? 0;

        // Pending Viva (viva_date null or in the future)
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            LEFT JOIN viva_records v ON s.student_id = v.student_id
            LEFT JOIN corrections c ON s.student_id = c.student_id
            LEFT JOIN graduation g ON s.student_id = g.student_id
            WHERE (v.viva_date IS NULL OR v.viva_date > CURDATE())
              AND (c.final_result IS NULL OR c.final_result = '')
              AND (g.graduation_date IS NULL)
        ");
        $stats['pending_viva'] = $this->db->single()['cnt'] ?? 0;

        return $stats;
    }

    /**
     * API endpoint for chart data
     */
    public function chartData(): void
    {
        Middleware::requireAdmin();

        $data = [
            'school_distribution' => $this->getSchoolDistribution(),
            'degree_distribution' => $this->getDegreeDistribution(),
            'status_distribution' => $this->getStatusDistribution()
        ];

        $this->jsonResponse($data);
    }

    private function getSchoolDistribution(): array
    {
        $this->db->query('SELECT school, COUNT(*) as count FROM students GROUP BY school ORDER BY count DESC');
        $results = $this->db->resultSet();
        
        $labels = [];
        $data = [];
        
        foreach ($results as $row) {
            $school = $row['school'] ?: 'Unassigned';
            // Shorten school names for chart
            $school = str_replace('School of ', '', $school);
            $labels[] = $school;
            $data[] = $row['count'];
        }
        
        return ['labels' => $labels, 'data' => $data];
    }

    private function getDegreeDistribution(): array
    {
        $this->db->query('SELECT degree_level, COUNT(*) as count FROM students GROUP BY degree_level');
        $results = $this->db->resultSet();
        
        $labels = [];
        $data = [];
        
        foreach ($results as $row) {
            $labels[] = $row['degree_level'];
            $data[] = $row['count'];
        }
        
        return ['labels' => $labels, 'data' => $data];
    }

    private function getStatusDistribution(): array
    {
        $this->db->query('SELECT research_status, COUNT(*) as count FROM students GROUP BY research_status');
        $results = $this->db->resultSet();
        
        $labels = [];
        $data = [];
        
        foreach ($results as $row) {
            $labels[] = $row['research_status'];
            $data[] = $row['count'];
        }
        
        return ['labels' => $labels, 'data' => $data];
    }
}
