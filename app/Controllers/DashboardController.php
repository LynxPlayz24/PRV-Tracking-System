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

        // 1. Upcoming Viva Sessions (within 30 days, missing result)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, v.viva_id, v.viva_date 
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.viva_date >= CURDATE() 
              AND v.viva_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
              AND (v.viva_result IS NULL OR v.viva_result = '')
            ORDER BY v.viva_date ASC
        ");
        $vivas = $this->db->resultSet();
        foreach ($vivas as $viva) {
            $key = 'viva_' . $viva['viva_id'] . '_' . $viva['viva_date'];

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $viva['student_id'],
                'name'       => $viva['name'],
                'matric_no'  => $viva['matric_no'],
                'type'       => 'Upcoming Viva',
                'date'       => $viva['viva_date'],
                'badge'      => 'bg-info text-dark',
                'icon'       => 'bi-calendar-event',
                'tab'        => 'viva',
                'highlight'  => 'viva_date'
            ];
        }

        // 2. Overdue Viva Outcome (Viva date passed, but viva result still missing)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, v.viva_id, v.viva_date 
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.viva_date < CURDATE()
              AND (v.viva_result IS NULL OR v.viva_result = '')
            ORDER BY v.viva_date DESC
        ");
        $pastVivas = $this->db->resultSet();
        foreach ($pastVivas as $pviva) {
            $key = 'pviva_' . $pviva['viva_id'] . '_' . $pviva['viva_date'];

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $pviva['student_id'],
                'name'       => $pviva['name'],
                'matric_no'  => $pviva['matric_no'],
                'type'       => 'Pending Viva Result',
                'date'       => $pviva['viva_date'],
                'badge'      => 'bg-danger text-white',
                'icon'       => 'bi-journal-x',
                'tab'        => 'viva',
                'highlight'  => 'viva_result'
            ];
        }

        // 3. Correction Deadlines (Overdue or Due Soon, thesis not received yet)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, c.correction_id, c.correction_deadline 
            FROM students s
            JOIN corrections c ON s.student_id = c.student_id
            WHERE c.correction_deadline IS NOT NULL 
              AND c.correction_deadline < DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
              AND (c.corrected_thesis_received_date IS NULL OR c.corrected_thesis_received_date = '')
            ORDER BY c.correction_deadline ASC
        ");
        $corrections = $this->db->resultSet();
        foreach ($corrections as $corr) {
            $isOverdue = (strtotime($corr['correction_deadline']) < time());
            $key = 'corr_' . $corr['correction_id'] . '_' . $corr['correction_deadline'];

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $corr['student_id'],
                'name'       => $corr['name'],
                'matric_no'  => $corr['matric_no'],
                'type'       => $isOverdue ? 'Overdue Correction' : 'Correction Due Soon',
                'date'       => $corr['correction_deadline'],
                'badge'      => $isOverdue ? 'bg-danger text-white' : 'bg-warning text-dark',
                'icon'       => $isOverdue ? 'bi-exclamation-triangle-fill' : 'bi-clock-history',
                'tab'        => 'postviva',
                'highlight'  => 'corrected_thesis_received_date'
            ];
        }

        // 4. Pending Honorarium Payments (Viva Completed but any honorarium numeric RM amount is missing, text string, or 0)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, v.viva_id, v.viva_date,
                   v.honorarium_chairperson, v.honorarium_internal, v.honorarium_external
            FROM students s
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE v.viva_date IS NOT NULL AND v.viva_date <= CURDATE()
              AND (
                  v.honorarium_chairperson IS NULL OR v.honorarium_chairperson NOT REGEXP '^[0-9]+(\\\\.[0-9]+)?$' OR CAST(v.honorarium_chairperson AS DECIMAL(10,2)) <= 0 OR
                  v.honorarium_internal IS NULL OR v.honorarium_internal NOT REGEXP '^[0-9]+(\\\\.[0-9]+)?$' OR CAST(v.honorarium_internal AS DECIMAL(10,2)) <= 0 OR
                  v.honorarium_external IS NULL OR v.honorarium_external NOT REGEXP '^[0-9]+(\\\\.[0-9]+)?$' OR CAST(v.honorarium_external AS DECIMAL(10,2)) <= 0
              )
            ORDER BY v.viva_date DESC
        ");
        $honorariums = $this->db->resultSet();
        foreach ($honorariums as $hon) {
            $key = 'hon_' . $hon['viva_id'];

            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $hon['student_id'],
                'name'       => $hon['name'],
                'matric_no'  => $hon['matric_no'],
                'type'       => 'Pending Honorarium',
                'date'       => $hon['viva_date'],
                'badge'      => 'bg-success text-white',
                'icon'       => 'bi-cash-coin',
                'tab'        => 'postviva',
                'highlight'  => 'honorarium_chairperson'
            ];
        }

        // 5. Missing Corrected Thesis Received (deadline passed, no thesis received)
        $this->db->query("
            SELECT s.student_id, s.name, s.matric_no, c.correction_id, c.correction_deadline
            FROM students s
            JOIN corrections c ON s.student_id = c.student_id
            WHERE c.correction_deadline IS NOT NULL
              AND c.correction_deadline < CURDATE()
              AND (c.corrected_thesis_received_date IS NULL OR c.corrected_thesis_received_date = '')
            ORDER BY c.correction_deadline ASC
        ");
        foreach ($this->db->resultSet() as $row) {
            $key = 'no_thesis_' . $row['correction_id'];
            $actions[] = [
                'alert_key'  => $key,
                'student_id' => $row['student_id'],
                'name'       => $row['name'],
                'matric_no'  => $row['matric_no'],
                'type'       => 'Corrected Thesis Not Received',
                'date'       => $row['correction_deadline'],
                'badge'      => 'bg-danger text-white',
                'icon'       => 'bi-file-earmark-x',
                'tab'        => 'postviva',
                'highlight'  => 'corrected_thesis_received_date'
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
        
        // 1. Examiner Confirmation Pending
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, 
                   se.examiner_id, se.role, se.email_date AS sent_date,
                   e.examiner_name AS staff_name, e.phone AS staff_phone, e.email AS staff_email
            FROM students s 
            JOIN student_examiners se ON s.student_id = se.student_id
            JOIN examiners e ON se.examiner_id = e.examiner_id
            WHERE se.email_date IS NOT NULL
              AND se.status = 'Pending'
              AND se.email_date <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_conf_' . $res['student_id'] . '_' . $res['examiner_id'];
            $prefix = strtolower($res['role']) . '_examiner_status';

            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: $res['role'] . ' Examiner',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => $res['role'] . ' Examiner',
                'task'         => 'Pending Examiner Confirmation',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'viva',
                'highlight'    => $prefix . '[' . $res['examiner_id'] . ']'
            ];
        }

        // 2. Examiner Report Pending
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, 
                   se.examiner_id, se.role,
                   COALESCE(NULLIF(v.thesis_to_panel_soft_copy_date, ''), NULLIF(v.thesis_to_panel_hard_copy_date, '')) AS sent_date,
                   e.examiner_name AS staff_name, e.phone AS staff_phone, e.email AS staff_email
            FROM students s 
            JOIN student_examiners se ON s.student_id = se.student_id
            JOIN examiners e ON se.examiner_id = e.examiner_id
            JOIN viva_records v ON s.student_id = v.student_id
            WHERE (NULLIF(v.thesis_to_panel_soft_copy_date, '') IS NOT NULL OR NULLIF(v.thesis_to_panel_hard_copy_date, '') IS NOT NULL)
              AND (se.report_date IS NULL)
              AND COALESCE(NULLIF(v.thesis_to_panel_soft_copy_date, ''), NULLIF(v.thesis_to_panel_hard_copy_date, '')) <= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_rpt_' . $res['student_id'] . '_' . $res['examiner_id'];
            $prefix = strtolower($res['role']) . '_examiner_report_date';

            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: $res['role'] . ' Examiner',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => $res['role'] . ' Examiner',
                'task'         => 'Pending Examiner Report',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'viva',
                'highlight'    => $prefix . '[' . $res['examiner_id'] . ']'
            ];
        }

        // 3. Supervisor Endorsement Pending (Post-Viva)
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, c.correction_id,
                   NULLIF(c.corrected_thesis_received_date, '') AS sent_date,
                   sup.supervisor_name AS staff_name, sup.phone AS staff_phone, sup.email AS staff_email
            FROM students s 
            JOIN corrections c ON s.student_id = c.student_id
            JOIN student_supervisors ss ON s.student_id = ss.student_id AND ss.role = 'main'
            JOIN supervisors sup ON ss.supervisor_id = sup.supervisor_id
            WHERE NULLIF(c.corrected_thesis_received_date, '') IS NOT NULL
              AND (c.supervisor_endorsement_date IS NULL OR c.supervisor_endorsement_date = '')
              AND NULLIF(c.corrected_thesis_received_date, '') <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_sv_end_' . $res['correction_id'];

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

        // 4. Examiner Endorsement Pending (sent to examiners 14+ days ago, no endorsement_from_examiner_date)
        $this->db->query("
            SELECT s.student_id, s.name AS student_name, s.matric_no, c.correction_id,
                   se.examiner_id, se.role,
                   COALESCE(NULLIF(c.sent_to_internal_date,''), NULLIF(c.sent_to_external_date,'')) AS sent_date,
                   e.examiner_name AS staff_name, e.phone AS staff_phone, e.email AS staff_email
            FROM students s
            JOIN corrections c ON s.student_id = c.student_id
            JOIN student_examiners se ON s.student_id = se.student_id
            JOIN examiners e ON se.examiner_id = e.examiner_id
            WHERE (NULLIF(c.sent_to_internal_date,'') IS NOT NULL OR NULLIF(c.sent_to_external_date,'') IS NOT NULL)
              AND (c.endorsement_from_examiner_date IS NULL OR c.endorsement_from_examiner_date = '')
              AND COALESCE(NULLIF(c.sent_to_internal_date,''), NULLIF(c.sent_to_external_date,'')) <= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
        ");
        foreach ($this->db->resultSet() as $res) {
            $key = 'staff_ex_end_' . $res['correction_id'] . '_' . $res['examiner_id'];
            $pending[] = [
                'alert_key'    => $key,
                'student_id'   => $res['student_id'],
                'student_name' => $res['student_name'],
                'matric_no'    => $res['matric_no'],
                'staff_name'   => $res['staff_name'] ?: $res['role'] . ' Examiner',
                'staff_phone'  => $res['staff_phone'] ?: '',
                'staff_email'  => $res['staff_email'] ?: '',
                'role'         => $res['role'] . ' Examiner',
                'task'         => 'Waiting for Examiner Endorsement',
                'sent_date'    => $res['sent_date'],
                'tab'          => 'postviva',
                'highlight'    => 'endorsement_from_examiner_date'
            ];
        }

        usort($pending, fn($a, $b) => strtotime($a['sent_date']) - strtotime($b['sent_date']));
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

        return $stats;
    }
}
