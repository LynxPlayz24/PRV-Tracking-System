<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware;

/**
 * SearchController manages the student search interface and AJAX live search endpoint.
 */
class SearchController extends Controller
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Show search page
     */
    public function index(): void
    {
        Middleware::requireLogin();

        // Retrieve unique schools to populate filter dropdowns.
        $this->db->query('SELECT DISTINCT school FROM students WHERE school IS NOT NULL ORDER BY school');
        $schools = $this->db->resultSet();
        $degrees = [
            'Diploma', 'Advanced Diploma', 'Postdoctoral', 'Associate Degree', 
            'APEL 7', 'Mobility', 'Program Upgrade', "Bachelor's Degree", 
            'Postgraduate Diploma', 'Masters', 'PhD', 'DBA', 
            'Certificate', 'Higher National Diploma', 'Executive Diploma'
        ];
        $statuses = [
            'Thesis Submitted', 'Examiner Assigned', 'Viva Scheduled', 
            'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'
        ];

        // Retrieve distinct viva years for the year filter.
        $this->db->query('SELECT DISTINCT YEAR(v.viva_date) AS viva_year FROM viva_records v WHERE v.viva_date IS NOT NULL ORDER BY viva_year DESC');
        $vivaYears = array_column($this->db->resultSet(), 'viva_year');

        // Retrieve distinct programmes for the programme filter.
        $this->db->query('SELECT DISTINCT programme FROM students WHERE programme IS NOT NULL AND programme != \'\' ORDER BY programme');
        $programmes = array_column($this->db->resultSet(), 'programme');

        $data = [
            'pageTitle'    => 'Search Students',
            'currentPage'  => 'search',
            'schools'      => array_column($schools, 'school'),
            'degrees'      => $degrees,
            'statuses'     => $statuses,
            'vivaYears'    => $vivaYears,
            'programmes'   => $programmes,
            'extraScripts' => ['search.js']
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('students.search', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * AJAX endpoint for live search
     */
    public function liveSearch(): void
    {
        Middleware::requireLogin();

        $query         = $this->param('q', '');
        $degree        = $this->param('degree', '');
        $school        = $this->param('school', '');
        $programme     = $this->param('programme', '');
        $researchStatus= $this->param('research_status', '');
        $vivaYear      = $this->param('viva_year', '');

        // H4: Use EXISTS subquery for supervisor matching to avoid JOIN fanout
        // (JOIN approach caused multi-supervisor students to consume multiple result slots before GROUP BY).
        $sql = "SELECT s.student_id, s.matric_no, s.name, s.programme, s.school, s.degree_level, s.research_status 
                FROM students s 
                LEFT JOIN viva_records v ON s.student_id = v.student_id
                WHERE 1=1 ";
        
        $params = [];

        if (!empty($query)) {
            $sql .= " AND (
                        s.name LIKE :q1 
                        OR s.matric_no LIKE :q2 
                        OR s.programme LIKE :q3 
                        OR s.school LIKE :q4 
                        OR s.thesis_title LIKE :q5
                        OR EXISTS (
                            SELECT 1 FROM student_supervisors ss2
                            JOIN supervisors sup2 ON ss2.supervisor_id = sup2.supervisor_id
                            WHERE ss2.student_id = s.student_id AND sup2.supervisor_name LIKE :q6
                        )
                      )";
            $params[':q1'] = "%{$query}%";
            $params[':q2'] = "%{$query}%";
            $params[':q3'] = "%{$query}%";
            $params[':q4'] = "%{$query}%";
            $params[':q5'] = "%{$query}%";
            $params[':q6'] = "%{$query}%";
        }

        if (!empty($degree)) {
            $sql .= " AND s.degree_level = :degree";
            $params[':degree'] = $degree;
        }

        if (!empty($school)) {
            $sql .= " AND s.school = :school";
            $params[':school'] = $school;
        }

        if (!empty($programme)) {
            $sql .= " AND s.programme = :programme";
            $params[':programme'] = $programme;
        }

        if (!empty($researchStatus)) {
            $sql .= " AND s.research_status = :research_status";
            $params[':research_status'] = $researchStatus;
        }

        if (!empty($vivaYear)) {
            $sql .= " AND YEAR(v.viva_date) = :viva_year";
            $params[':viva_year'] = (int)$vivaYear;
        }

        $sql .= " GROUP BY s.student_id ORDER BY s.name ASC LIMIT 50";

        $this->db->query($sql);
        $results = $this->db->resultSet($params);

        // Map research statuses to corresponding CSS badge classes.
        foreach ($results as &$row) {
            $row['status_badge'] = $this->getStatusBadgeClass($row['research_status']);
        }

        $this->jsonResponse(['results' => $results]);
    }

    private function getStatusBadgeClass(string $status): string
    {
        $map = [
            'Thesis Submitted'      => 'badge-thesis-submitted',
            'Examiner Assigned'     => 'badge-examiner-assigned',
            'Viva Scheduled'        => 'badge-viva-scheduled',
            'Viva Completed'        => 'badge-viva-completed',
            'Corrections Submitted' => 'badge-corrections-submitted',
            'Ready for Senate'      => 'badge-ready-senate',
            'Graduated'             => 'badge-graduated'
        ];
        return $map[$status] ?? 'bg-secondary';
    }
}
