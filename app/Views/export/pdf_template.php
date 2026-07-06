<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Report - <?= htmlspecialchars($student['matric_no']) ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #003399;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #003399;
            margin: 0 0 3px 0;
            font-size: 22px;
        }
        .header h2 {
            color: #003399;
            margin: 0 0 5px 0;
            font-size: 17px;
            font-weight: 600;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 11px;
        }
        .section {
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f0f2f8;
            color: #003399;
            padding: 7px 10px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border-left: 4px solid #FFCC00;
            page-break-after: avoid;
        }
        .sub-section-title {
            color: #003399;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px solid #e0e0e0;
            page-break-after: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        th, td {
            padding: 5px 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        th {
            width: 38%;
            color: #555;
            font-weight: 600;
            background-color: #fafafa;
        }
        td {
            width: 62%;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            background: #eee;
            color: #333;
        }
        .badge-role { background: #e8eef8; color: #003399; }
        .badge-yes { background: #d4edda; color: #155724; }
        .badge-no { background: #f8d7da; color: #721c24; }
        .text-highlight { color: #003399; font-weight: bold; }
        .text-success { color: #198754; font-weight: bold; }
        .text-danger { color: #dc3545; font-weight: bold; }
        .text-muted { color: #999; }
        table { page-break-inside: avoid; }
    </style>
</head>
<body>

<?php
// Helper functions
if (!function_exists('pdfDate')) {
    function pdfDate($date) {
        if (empty($date) || $date === '0000-00-00') return '<span class="text-muted">-</span>';
        return date('d M Y', strtotime($date));
    }
}
if (!function_exists('pdfVal')) {
    function pdfVal($val) {
        return empty($val) ? '<span class="text-muted">-</span>' : htmlspecialchars($val);
    }
}

$viva = $student['viva_records'][0] ?? [];
$corr = $student['correction'] ?? [];
$grad = $student['graduation'] ?? [];
$mainSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'main');
$coSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'co');
?>

    <div class="header">
        <h1>Universiti Utara Malaysia</h1>
        <h2>Ghazali Shafie Graduate School of Government</h2>
        <p>Postgraduate Research & Viva Tracking System (PRVTS) &mdash; Student Report</p>
    </div>

    <!-- =============================================
         SECTION 1: PERSONAL & ACADEMIC INFORMATION
         ============================================= -->
    <div class="section">
    <div class="section-title">Personal & Academic Information</div>
    <table>
        <tr>
            <th>Full Name</th>
            <td><strong><?= htmlspecialchars($student['name']) ?></strong></td>
        </tr>
        <tr>
            <th>Matric Number</th>
            <td><strong><?= htmlspecialchars($student['matric_no']) ?></strong></td>
        </tr>
        <tr>
            <th>Programme</th>
            <td><?= pdfVal($student['programme']) ?></td>
        </tr>
        <tr>
            <th>School</th>
            <td><?= pdfVal($student['school'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Degree Level</th>
            <td><?= htmlspecialchars($student['degree_level']) ?></td>
        </tr>
        <tr>
            <th>Cohort</th>
            <td><?= pdfVal($student['cohort'] ?? null) ?></td>
        </tr>
        <tr>
            <th>ITS Receipt Date</th>
            <td><?= pdfDate($student['its_receipt_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Overall Status</th>
            <td><strong class="text-highlight"><?= htmlspecialchars($student['research_status']) ?></strong></td>
        </tr>
    </table>
    </div>

    <!-- =============================================
         SECTION 2: RESEARCH INFORMATION
         ============================================= -->
    <div class="section">
    <div class="section-title">Research Information</div>
    <table>
        <tr>
            <th>Thesis Title</th>
            <td><em>"<?= htmlspecialchars($student['thesis_title'] ?: 'Not Specified') ?>"</em></td>
        </tr>
        <tr>
            <th>Main Supervisor(s)</th>
            <td>
                <?php if ($mainSups): ?>
                    <?php foreach ($mainSups as $s): ?>
                        <div><?= htmlspecialchars($s['supervisor_name']) ?> <span class="badge badge-role">MAIN</span></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Co-Supervisor(s)</th>
            <td>
                <?php if ($coSups): ?>
                    <?php foreach ($coSups as $s): ?>
                        <div><?= htmlspecialchars($s['supervisor_name']) ?> <span class="badge badge-role">CO</span></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>JIL Meeting Date</th>
            <td><?= pdfDate($grad['jil_meeting_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>JIL Meeting No.</th>
            <td><?= pdfVal($grad['jil_meeting_no'] ?? null) ?></td>
        </tr>
    </table>
    </div>

    <!-- =============================================
         SECTION 3: DRAFT THESIS REQUIREMENTS
         ============================================= -->
    <div class="section">
    <div class="section-title">Draft Thesis Requirements</div>
    <table>
        <tr>
            <th>Submission Email Date</th>
            <td><?= pdfDate($viva['thesis_submission_email_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>4 Hard Copy Date</th>
            <td><?= pdfDate($viva['draft_hard_copy_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Soft Copy Date</th>
            <td><?= pdfDate($viva['draft_soft_copy_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Turnitin Percentage</th>
            <td><?= pdfVal($viva['turnitin_percentage'] ?? null) ?><?= !empty($viva['turnitin_percentage']) ? ' %' : '' ?></td>
        </tr>
        <tr>
            <th>Submission Form Date</th>
            <td><?= pdfDate($viva['draft_submission_form_date'] ?? null) ?></td>
        </tr>
    </table>
    </div>

    <!-- =============================================
         SECTION 4: EXAMINATION PANEL & VIVA
         ============================================= -->
    <div class="section">
    <div class="section-title">Examination Panel & Viva Arrangements</div>

    <div class="sub-section-title">Panel Members</div>
    <table>
        <tr>
            <th>Chairperson</th>
            <td><strong><?= pdfVal($viva['chairperson_name'] ?? null) ?></strong></td>
        </tr>
        <tr>
            <th>Internal Examiner</th>
            <td><strong><?= pdfVal($viva['examiner_name'] ?? null) ?></strong></td>
        </tr>
        <tr>
            <th>External Examiner</th>
            <td><strong><?= pdfVal($viva['external_examiner_name'] ?? null) ?></strong></td>
        </tr>
    </table>

    <div class="sub-section-title">Panel Arrangement Dates</div>
    <table>
        <tr>
            <th>Internal Examiner Email Persetujuan</th>
            <td><?= pdfDate($viva['internal_examiner_email_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>External Examiner Email Persetujuan</th>
            <td><?= pdfDate($viva['external_examiner_email_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Panel Appointment Letter</th>
            <td><?= pdfDate($viva['panel_appointment_letter_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Thesis to Panel (Hard Copy)</th>
            <td><?= pdfDate($viva['thesis_to_panel_hard_copy_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Thesis to Panel (Soft Copy)</th>
            <td><?= pdfDate($viva['thesis_to_panel_soft_copy_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Confirm Date Email</th>
            <td><?= pdfDate($viva['confirm_date_email_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Invitation Letter</th>
            <td><?= pdfDate($viva['invitation_letter_date'] ?? null) ?></td>
        </tr>
    </table>

    <div class="sub-section-title">Viva-Voce</div>
    <table>
        <tr>
            <th>Viva Date</th>
            <td><strong class="text-highlight"><?= pdfDate($viva['viva_date'] ?? null) ?></strong></td>
        </tr>
        <tr>
            <th>Viva Result</th>
            <td><strong class="text-success"><?= pdfVal($viva['viva_result'] ?? null) ?></strong></td>
        </tr>
        <tr>
            <th>Internal Examiner Report Received</th>
            <td><?= pdfDate($viva['internal_examiner_report_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Best Thesis Candidate</th>
            <td><?= !empty($viva['best_thesis_candidate']) ? '<span class="badge badge-yes">★ Yes</span>' : 'No' ?></td>
        </tr>
    </table>
    </div>

    <!-- =============================================
         SECTION 5: POST-VIVA CORRECTIONS
         ============================================= -->
    <div class="section">
    <div class="section-title">Post-Viva Corrections & Submission</div>
    <table>
        <tr>
            <th>Correction Deadline</th>
            <td><strong class="text-danger"><?= pdfDate($corr['correction_deadline'] ?? null) ?></strong></td>
        </tr>
        <tr>
            <th>Reviewed By</th>
            <td><?= pdfVal($corr['reviewed_by'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Report Sent to Student</th>
            <td><?= pdfDate($corr['report_sent_to_student_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Internal Report Status</th>
            <td><?= pdfVal($corr['internal_report_status'] ?? null) ?></td>
        </tr>
        <tr>
            <th>External Report Status</th>
            <td><?= pdfVal($corr['external_report_status'] ?? null) ?></td>
        </tr>
    </table>

    <div class="sub-section-title">Corrected Thesis Tracking</div>
    <table>
        <tr>
            <th>Thesis Received</th>
            <td><?= pdfDate($corr['corrected_thesis_received_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Checklist After Viva</th>
            <td><?= pdfDate($corr['checklist_after_viva_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Correction Schedule</th>
            <td><?= pdfDate($corr['correction_schedule_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Post-Viva Turnitin</th>
            <td><?= pdfVal($corr['post_viva_turnitin_percentage'] ?? null) ?><?= !empty($corr['post_viva_turnitin_percentage']) ? ' %' : '' ?></td>
        </tr>
        <tr>
            <th>SV Endorsement</th>
            <td><?= pdfDate($corr['supervisor_endorsement_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Sent to Internal Examiner</th>
            <td><?= pdfDate($corr['sent_to_internal_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Sent to External Examiner</th>
            <td><?= pdfDate($corr['sent_to_external_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Sent to Supervisor</th>
            <td><?= pdfDate($corr['sent_to_supervisor_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Endorsement from Examiner</th>
            <td><?= pdfDate($corr['endorsement_from_examiner_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Abstract Received</th>
            <td><?= pdfDate($corr['abstract_received_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Final Result</th>
            <td><strong class="text-success"><?= pdfVal($corr['final_result'] ?? null) ?></strong></td>
        </tr>
    </table>
    </div>

    <!-- =============================================
         SECTION 6: HONORARIUM DETAILS
         ============================================= -->
    <div class="section">
    <div class="section-title">Honorarium Details</div>
    <table>
        <tr>
            <th>Chairperson</th>
            <td><?= pdfVal($viva['honorarium_chairperson'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Internal Examiner</th>
            <td><?= pdfVal($viva['honorarium_internal'] ?? null) ?></td>
        </tr>
        <tr>
            <th>External Examiner</th>
            <td><?= pdfVal($viva['honorarium_external'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Refreshment</th>
            <td><?= pdfVal($viva['honorarium_refreshment'] ?? null) ?></td>
        </tr>
    </table>
    </div>

    <!-- =============================================
         SECTION 7: GRADUATION & INSTITUTIONAL APPROVALS
         ============================================= -->
    <div class="section">
    <div class="section-title">Institutional Approvals & Graduation</div>
    <table>
        <tr>
            <th>GAIS Key-in Date</th>
            <td><?= pdfDate($grad['gais_keyin_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Senate Meeting Date</th>
            <td><?= pdfDate($grad['senate_meeting_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Senate Meeting No.</th>
            <td><?= pdfVal($grad['senate_meeting_no'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Senate Status</th>
            <td><strong class="text-highlight"><?= pdfVal($grad['senate_status'] ?? null) ?></strong></td>
        </tr>
        <tr>
            <th>Thesis Certification Date</th>
            <td><?= pdfDate($grad['thesis_certification_date'] ?? null) ?></td>
        </tr>
    </table>

    <div class="sub-section-title">Final Document Submissions</div>
    <table>
        <tr>
            <th>Final Thesis Form</th>
            <td><?= pdfDate($grad['final_thesis_form_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Hard Bound Copies</th>
            <td><?= pdfDate($grad['hard_bound_copies_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Loose Copy</th>
            <td><?= pdfDate($grad['loose_copy_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>CD Copies</th>
            <td><?= pdfDate($grad['cd_copies_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>ETD Form</th>
            <td><?= pdfDate($grad['etd_form_date'] ?? null) ?></td>
        </tr>
        <tr>
            <th>Sent to PSB</th>
            <td><?= pdfDate($grad['sent_to_psb_date'] ?? null) ?></td>
        </tr>
    </table>

    <table style="margin-top: 10px;">
        <tr>
            <th style="font-size: 14px;">Graduation Date</th>
            <td><strong class="text-success" style="font-size: 14px;"><?= pdfDate($grad['graduation_date'] ?? null) ?></strong></td>
        </tr>
    </table>
    </div>

    <div class="footer">
        Generated by GSGSG PRV Tracking System on <?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?><?= date('d M Y H:i:s') ?> &bull; Universiti Utara Malaysia
    </div>

</body>
</html>
