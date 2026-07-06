<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Middleware;

/**
 * SearchController
 * Handles the student search interface and AJAX live search endpoint.
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

        // Get filter options for dropdowns
        $this->db->query('SELECT DISTINCT school FROM students WHERE school IS NOT NULL ORDER BY school');
        $schools = $this->db->resultSet();
        $degrees = ['Masters', 'PhD', 'DBA'];
        $statuses = [
            'Thesis Submitted', 'Examiner Assigned', 'Viva Scheduled', 
            'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'
        ];

        $data = [
            'pageTitle'    => 'Search Students',
            'currentPage'  => 'search',
            'schools'      => array_column($schools, 'school'),
            'degrees'      => $degrees,
            'statuses'     => $statuses,
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
        $researchStatus= $this->param('research_status', '');

        $sql = "SELECT s.student_id, s.matric_no, s.name, s.programme, s.school, s.degree_level, s.research_status 
                FROM students s 
                LEFT JOIN student_supervisors ss ON s.student_id = ss.student_id 
                LEFT JOIN supervisors sup ON ss.supervisor_id = sup.supervisor_id
                WHERE 1=1 ";
        
        $params = [];

        if (!empty($query)) {
            $sql .= " AND (
                        s.name LIKE :q1 
                        OR s.matric_no LIKE :q2 
                        OR s.programme LIKE :q3 
                        OR s.school LIKE :q4 
                        OR s.thesis_title LIKE :q5
                        OR sup.supervisor_name LIKE :q6
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

        if (!empty($researchStatus)) {
            $sql .= " AND s.research_status = :research_status";
            $params[':research_status'] = $researchStatus;
        }

        $sql .= " GROUP BY s.student_id ORDER BY s.name ASC LIMIT 50";

        $this->db->query($sql);
        $results = $this->db->resultSet($params);

        // Map status to badge classes
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
