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

        // Intake years for school chart filter
        $this->db->query('SELECT DISTINCT YEAR(its_receipt_date) AS yr FROM students WHERE its_receipt_date IS NOT NULL ORDER BY yr DESC');
        $intakeYears = array_column($this->db->resultSet(), 'yr');

        // Viva years for top panel roles month/year filter
        $this->db->query('SELECT DISTINCT YEAR(viva_date) AS yr FROM viva_records WHERE viva_date IS NOT NULL ORDER BY yr DESC');
        $vivaYears = array_column($this->db->resultSet(), 'yr');

        $data = [
            'pageTitle'   => 'Analytics Dashboard',
            'currentPage' => 'analytics',
            'stats'       => $stats,
            'intakeYears' => $intakeYears,
            'vivaYears'   => $vivaYears,
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
        $stats['total_students'] = (int)($this->db->single()['cnt'] ?? 0);

        // Graduated (graduation_date is set or research_status = 'Graduated')
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            LEFT JOIN graduation g ON s.student_id = g.student_id 
            WHERE s.research_status = 'Graduated'
               OR (g.graduation_date IS NOT NULL AND g.graduation_date != '' AND g.graduation_date != '0000-00-00')
        ");
        $stats['graduated'] = (int)($this->db->single()['cnt'] ?? 0);

        // Ready for Senate (final_result or senate_meeting_date is set, but not graduated)
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            LEFT JOIN corrections c ON s.student_id = c.student_id
            LEFT JOIN graduation g ON s.student_id = g.student_id
            WHERE (
                s.research_status = 'Ready for Senate'
                OR (c.final_result IS NOT NULL AND c.final_result != '')
                OR (g.senate_meeting_date IS NOT NULL AND g.senate_meeting_date != '' AND g.senate_meeting_date != '0000-00-00')
            )
            AND (g.graduation_date IS NULL OR g.graduation_date = '' OR g.graduation_date = '0000-00-00')
            AND s.research_status != 'Graduated'
        ");
        $stats['ready_for_senate'] = (int)($this->db->single()['cnt'] ?? 0);

        // Awaiting Corrections (status-driven: only explicit in-progress correction statuses)
        $this->db->query("
            SELECT COUNT(DISTINCT s.student_id) as cnt 
            FROM students s 
            LEFT JOIN corrections c ON s.student_id = c.student_id
            WHERE s.research_status IN ('Viva Completed', 'Corrections Submitted')
              AND (c.final_result IS NULL OR c.final_result = '')
        ");
        $stats['awaiting_corrections'] = (int)($this->db->single()['cnt'] ?? 0);

        // Pending Viva
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM students s 
            LEFT JOIN viva_records v ON s.student_id = v.student_id
            LEFT JOIN corrections c ON s.student_id = c.student_id
            LEFT JOIN graduation g ON s.student_id = g.student_id
            WHERE (
                s.research_status IN ('Thesis Submitted', 'Examiner Assigned', 'Viva Scheduled')
                OR (v.viva_date IS NULL OR v.viva_date = '' OR v.viva_date > CURDATE())
            )
            AND (c.final_result IS NULL OR c.final_result = '')
            AND (g.senate_meeting_date IS NULL OR g.senate_meeting_date = '' OR g.senate_meeting_date = '0000-00-00')
            AND (g.graduation_date IS NULL OR g.graduation_date = '' OR g.graduation_date = '0000-00-00')
            AND (v.viva_result IS NULL OR v.viva_result = '')
            AND (v.viva_date IS NULL OR v.viva_date = '' OR v.viva_date > CURDATE())
            AND s.research_status NOT IN ('Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated')
        ");
        $stats['pending_viva'] = (int)($this->db->single()['cnt'] ?? 0);

        // Financial & Operational Metrics
        $this->db->query("SELECT SUM(amount) as total FROM honorarium_payments");
        $stats['total_viva_budget'] = $this->db->single()['total'] ?? 0;

        $this->db->query("SELECT COUNT(*) as cnt FROM student_supervisors");
        $stats['total_supervisors_assigned'] = $this->db->single()['cnt'] ?? 0;

        $this->db->query("SELECT COUNT(*) as cnt FROM student_examiners");
        $stats['total_examiners_assigned'] = $this->db->single()['cnt'] ?? 0;

        return $stats;
    }

    /**
     * API endpoint for chart data — accepts GET filter params:
     *   month, year (filter by viva_date), degree_level, status, intake_year
     */
    public function chartData(): void
    {
        Middleware::requireAdmin();

        $month       = (int)($_GET['month'] ?? 0);
        $year        = (int)($_GET['year'] ?? 0);
        $degreeLevel = trim($_GET['degree_level'] ?? '');
        $status      = trim($_GET['status'] ?? '');
        $intakeYear  = (int)($_GET['intake_year'] ?? 0);

        $data = [
            'school_distribution' => $this->getSchoolDistribution($degreeLevel, $status, $intakeYear),
            'degree_distribution' => $this->getDegreeDistribution(),
            'status_distribution' => $this->getStatusDistribution(),
            'top_panel_roles'     => $this->getTopPanelRoles($month, $year),
        ];

        $this->jsonResponse($data);
    }

    /**
     * Top Panel Roles: top supervisors, co-supervisors, chairpersons, examiners
     * Optionally filtered by viva_date month/year.
     */
    private function getTopPanelRoles(int $month = 0, int $year = 0): array
    {
        $dateJoin  = "JOIN viva_records v ON s.student_id = v.student_id";
        $dateWhere = "WHERE 1=1";
        $params    = [];

        if ($month > 0) {
            $dateWhere .= " AND MONTH(v.viva_date) = :month";
            $params[':month'] = $month;
        }
        if ($year > 0) {
            $dateWhere .= " AND YEAR(v.viva_date) = :year";
            $params[':year'] = $year;
        }

        // Top Main Supervisors
        $this->db->query("
            SELECT sup.supervisor_name AS name, COUNT(*) AS total
            FROM student_supervisors ss
            JOIN supervisors sup ON ss.supervisor_id = sup.supervisor_id
            JOIN students s ON ss.student_id = s.student_id
            $dateJoin
            $dateWhere
              AND ss.role = 'main'
            GROUP BY sup.supervisor_id
            ORDER BY total DESC
            LIMIT 3
        ");
        $topSupervisors = $this->db->resultSet($params);

        // Top Co-Supervisors
        $this->db->query("
            SELECT sup.supervisor_name AS name, COUNT(*) AS total
            FROM student_supervisors ss
            JOIN supervisors sup ON ss.supervisor_id = sup.supervisor_id
            JOIN students s ON ss.student_id = s.student_id
            $dateJoin
            $dateWhere
              AND ss.role = 'co'
            GROUP BY sup.supervisor_id
            ORDER BY total DESC
            LIMIT 3
        ");
        $topCoSupervisors = $this->db->resultSet($params);

        // Top Chairpersons (from viva_records.chairperson_name)
        $this->db->query("
            SELECT v.chairperson_name AS name, COUNT(*) AS total
            FROM viva_records v
            JOIN students s ON v.student_id = s.student_id
            $dateWhere
              AND v.chairperson_name IS NOT NULL AND v.chairperson_name != ''
            GROUP BY v.chairperson_name
            ORDER BY total DESC
            LIMIT 3
        ");
        $topChairpersons = $this->db->resultSet($params);

        // Top Examiners (combined internal + external)
        $this->db->query("
            SELECT e.examiner_name AS name, COUNT(*) AS total
            FROM student_examiners se
            JOIN examiners e ON se.examiner_id = e.examiner_id
            JOIN students s ON se.student_id = s.student_id
            $dateJoin
            $dateWhere
            GROUP BY e.examiner_id
            ORDER BY total DESC
            LIMIT 3
        ");
        $topExaminers = $this->db->resultSet($params);

        return [
            'supervisors'    => $topSupervisors,
            'co_supervisors' => $topCoSupervisors,
            'chairpersons'   => $topChairpersons,
            'examiners'      => $topExaminers,
        ];
    }

    /**
     * School distribution with optional filters.
     */
    private function getSchoolDistribution(string $degreeLevel = '', string $status = '', int $intakeYear = 0): array
    {
        $where  = "WHERE 1=1";
        $params = [];

        if ($degreeLevel !== '') {
            $where .= " AND degree_level = :degree_level";
            $params[':degree_level'] = $degreeLevel;
        }
        if ($status !== '') {
            $where .= " AND research_status = :status";
            $params[':status'] = $status;
        }
        if ($intakeYear > 0) {
            $where .= " AND YEAR(its_receipt_date) = :intake_year";
            $params[':intake_year'] = $intakeYear;
        }

        $this->db->query("SELECT school, COUNT(*) as count FROM students $where GROUP BY school ORDER BY count DESC");
        $results = $this->db->resultSet($params);

        $labels = [];
        $data   = [];

        foreach ($results as $row) {
            $labels[] = $row['school'] ?: 'Not Assigned';
            $data[]   = (int)$row['count'];
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getDegreeDistribution(): array
    {
        $this->db->query('SELECT degree_level, COUNT(*) as count FROM students GROUP BY degree_level');
        $results = $this->db->resultSet();

        $labels = [];
        $data   = [];

        foreach ($results as $row) {
            $labels[] = $row['degree_level'] ?: 'Not Specified';
            $data[]   = (int)$row['count'];
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getStatusDistribution(): array
    {
        $this->db->query('SELECT research_status, COUNT(*) as count FROM students GROUP BY research_status');
        $results = $this->db->resultSet();

        $labels = [];
        $data   = [];

        foreach ($results as $row) {
            $labels[] = $row['research_status'] ?: 'Not Set';
            $data[]   = (int)$row['count'];
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
