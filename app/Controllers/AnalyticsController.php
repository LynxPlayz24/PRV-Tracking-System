<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;

class AnalyticsController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = \App\Core\Database::getInstance();
    }

    public function index(): void
    {
        Middleware::requireAdmin();

        $stats = $this->getStats();

        $data = [
            'pageTitle'   => 'Analytics Dashboard',
            'currentPage' => 'analytics',
            'stats'       => $stats
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('analytics.index', $data);
        $this->view('layouts.footer', $data);
    }

    private function getStats(): array
    {
        $stats = [];

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

        // Financial & Operational Metrics
        $this->db->query("
            SELECT SUM(CAST(NULLIF(honorarium_chairperson, '') AS DECIMAL(10,2)) 
                     + CAST(NULLIF(honorarium_internal, '') AS DECIMAL(10,2)) 
                     + CAST(NULLIF(honorarium_external, '') AS DECIMAL(10,2)) 
                     + CAST(NULLIF(honorarium_refreshment, '') AS DECIMAL(10,2))) as total 
            FROM viva_records
        ");
        $stats['total_viva_budget'] = $this->db->single()['total'] ?? 0;

        $this->db->query("SELECT COUNT(*) as cnt FROM student_supervisors");
        $stats['total_supervisors_assigned'] = $this->db->single()['cnt'] ?? 0;

        $this->db->query("SELECT COUNT(*) as cnt FROM student_examiners");
        $stats['total_examiners_assigned'] = $this->db->single()['cnt'] ?? 0;

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
            $labels[] = $row['school'] ?: 'Not Assigned';
            $data[] = (int)$row['count'];
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
            $labels[] = $row['degree_level'] ?: 'Not Specified';
            $data[] = (int)$row['count'];
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
            $labels[] = $row['research_status'] ?: 'Not Set';
            $data[] = (int)$row['count'];
        }
        
        return ['labels' => $labels, 'data' => $data];
    }
}
