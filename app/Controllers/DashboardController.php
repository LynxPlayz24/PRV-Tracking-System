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

    /**
     * Resolve / Mark as Done an alert item
     */
    public function resolveAlert(): void
    {
        Middleware::requireAdmin();

        $alertKey = trim($this->input('alert_key', ''));
        if (empty($alertKey)) {
            $this->jsonResponse(['success' => false, 'message' => 'Alert key is required']);
            return;
        }

        $resolvedBy = $_SESSION['user_name'] ?? $_SESSION['user']['name'] ?? 'Admin';

        $this->db->query("
            INSERT INTO alert_resolutions (alert_key, resolved_by) 
            VALUES (:key, :by)
            ON DUPLICATE KEY UPDATE resolved_at = CURRENT_TIMESTAMP
        ");
        $this->db->bind(':key', $alertKey);
        $this->db->bind(':by', $resolvedBy);
        $success = $this->db->execute();

        $this->jsonResponse(['success' => (bool)$success]);
    }

    /**
     * Get list of resolved alert keys
     */
    private function getResolvedAlertKeys(): array
    {
        $this->db->query("SELECT alert_key FROM alert_resolutions");
        $rows = $this->db->resultSet();
        return array_column($rows, 'alert_key');
    }

    private function getActionRequired(): array
    {
        $actions = [];
        $resolvedKeys = $this->getResolvedAlertKeys();

        // 1. Upcoming Viva Sessions (within 30 days)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, v.viva_id, v.viva_date 
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.viva_date >= CURDATE() AND v.viva_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
            ORDER BY v.viva_date ASC
            LIMIT 10
        ");
        $vivas = $this->db->resultSet();
        foreach ($vivas as $viva) {
            $key = 'viva_' . $viva['viva_id'] . '_' . $viva['viva_date'];
            if (in_array($key, $resolvedKeys)) continue;

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $viva['student_id'],
                'name'       => $viva['name'],
                'matric_no'  => $viva['matric_no'],
                'type'       => 'Upcoming Viva',
                'date'       => $viva['viva_date'],
                'badge'      => 'bg-info text-dark',
                'icon'       => 'bi-calendar-event',
                'tab'        => 'viva'
            ];
        }

        // 2. Correction Deadlines (Overdue or Due Soon)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, c.correction_id, c.correction_deadline 
            FROM students s
            JOIN corrections c ON s.student_id = c.student_id
            WHERE c.correction_deadline IS NOT NULL 
              AND c.correction_deadline < DATE_ADD(CURDATE(), INTERVAL 14 DAY)
              AND c.corrected_thesis_received_date IS NULL
            ORDER BY c.correction_deadline ASC
            LIMIT 10
        ");
        $corrections = $this->db->resultSet();
        foreach ($corrections as $corr) {
            $isOverdue = (strtotime($corr['correction_deadline']) < time());
            $key = 'corr_' . $corr['correction_id'] . '_' . $corr['correction_deadline'];
            if (in_array($key, $resolvedKeys)) continue;

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $corr['student_id'],
                'name'       => $corr['name'],
                'matric_no'  => $corr['matric_no'],
                'type'       => $isOverdue ? 'Overdue Correction' : 'Correction Due Soon',
                'date'       => $corr['correction_deadline'],
                'badge'      => $isOverdue ? 'bg-danger text-white' : 'bg-warning text-dark',
                'icon'       => $isOverdue ? 'bi-exclamation-triangle-fill' : 'bi-clock-history',
                'tab'        => 'postviva'
            ];
        }

        // 3. Pending Honorarium Payments (Viva Completed but Honorarium pending / unpaid)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, v.viva_id, v.viva_date,
                   v.honorarium_chairperson, v.honorarium_internal, v.honorarium_external
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.viva_date IS NOT NULL AND v.viva_date <= CURDATE()
              AND (
                  (v.honorarium_chairperson IS NOT NULL AND v.honorarium_chairperson != '' AND v.honorarium_chairperson != 'Paid') OR
                  (v.honorarium_internal IS NOT NULL AND v.honorarium_internal != '' AND v.honorarium_internal != 'Paid') OR
                  (v.honorarium_external IS NOT NULL AND v.honorarium_external != '' AND v.honorarium_external != 'Paid')
              )
            ORDER BY v.viva_date DESC
            LIMIT 10
        ");
        $honorariums = $this->db->resultSet();
        foreach ($honorariums as $hon) {
            $key = 'hon_' . $hon['viva_id'];
            if (in_array($key, $resolvedKeys)) continue;

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $hon['student_id'],
                'name'       => $hon['name'],
                'matric_no'  => $hon['matric_no'],
                'type'       => 'Pending Honorarium',
                'date'       => $hon['viva_date'],
                'badge'      => 'bg-success text-white',
                'icon'       => 'bi-cash-coin',
                'tab'        => 'postviva'
            ];
        }

        return $actions;
    }

    /**
     * Refined Pending Responses section focused specifically on Academic Staff
     */
    private function getPendingResponses(): array
    {
        $pending = [];
        $resolvedKeys = $this->getResolvedAlertKeys();
        
        // 1. Internal Examiner Confirmation Pending
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, v.viva_id,
                   v.internal_examiner_email_date AS sent_date,
                   e.examiner_name AS staff_name, e.phone AS staff_phone, e.email AS staff_email
            FROM students s 
            JOIN viva_records v ON s.student_id = v.student_id
            LEFT JOIN examiners e ON v.internal_examiner_id = e.examiner_id
            WHERE v.internal_examiner_email_date IS NOT NULL 
              AND v.internal_examiner_status = 'Pending'
              AND v.internal_examiner_email_date <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_int_conf_' . $res['viva_id'];
            if (in_array($key, $resolvedKeys)) continue;

            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: 'Internal Examiner',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => 'Internal Examiner',
                'task'         => 'Pending Examiner Confirmation',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'viva'
            ];
        }

        // 2. External Examiner Confirmation Pending
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, v.viva_id,
                   v.external_examiner_email_date AS sent_date,
                   e.examiner_name AS staff_name, e.phone AS staff_phone, e.email AS staff_email
            FROM students s 
            JOIN viva_records v ON s.student_id = v.student_id
            LEFT JOIN examiners e ON v.external_examiner_id = e.examiner_id
            WHERE v.external_examiner_email_date IS NOT NULL 
              AND v.external_examiner_status = 'Pending'
              AND v.external_examiner_email_date <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_ext_conf_' . $res['viva_id'];
            if (in_array($key, $resolvedKeys)) continue;

            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: 'External Examiner',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => 'External Examiner',
                'task'         => 'Pending Examiner Confirmation',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'viva'
            ];
        }

        // 3. Internal Examiner Report Pending
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, v.viva_id,
                   COALESCE(v.thesis_to_panel_soft_copy_date, v.thesis_to_panel_hard_copy_date) AS sent_date,
                   e.examiner_name AS staff_name, e.phone AS staff_phone, e.email AS staff_email
            FROM students s 
            JOIN viva_records v ON s.student_id = v.student_id
            LEFT JOIN examiners e ON v.internal_examiner_id = e.examiner_id
            WHERE (v.thesis_to_panel_soft_copy_date IS NOT NULL OR v.thesis_to_panel_hard_copy_date IS NOT NULL)
              AND v.internal_examiner_report_date IS NULL
              AND COALESCE(v.thesis_to_panel_soft_copy_date, v.thesis_to_panel_hard_copy_date) <= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_int_rpt_' . $res['viva_id'];
            if (in_array($key, $resolvedKeys)) continue;

            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: 'Internal Examiner',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => 'Internal Examiner',
                'task'         => 'Waiting for Examiner Evaluation Report',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'viva'
            ];
        }

        // 4. Supervisor Endorsement Pending (Post-Viva)
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, c.correction_id,
                   c.corrected_thesis_received_date AS sent_date,
                   sup.supervisor_name AS staff_name, sup.phone AS staff_phone, sup.email AS staff_email
            FROM students s 
            JOIN corrections c ON s.student_id = c.student_id
            JOIN student_supervisors ss ON s.student_id = ss.student_id AND ss.role = 'main'
            JOIN supervisors sup ON ss.supervisor_id = sup.supervisor_id
            WHERE c.corrected_thesis_received_date IS NOT NULL 
              AND c.supervisor_endorsement_date IS NULL
              AND c.corrected_thesis_received_date <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_sv_end_' . $res['correction_id'];
            if (in_array($key, $resolvedKeys)) continue;

            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: 'Main Supervisor',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => 'Main Supervisor',
                'task'         => 'Waiting for Supervisor Endorsement',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'postviva'
            ];
        }

        usort($pending, fn($a, $b) => strtotime($a['sent_date']) - strtotime($b['sent_date']));
        return array_slice($pending, 0, 10);
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
