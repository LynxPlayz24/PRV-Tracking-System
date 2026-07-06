<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$viva = reset($student['viva_records']) ?: [];
$corr = $student['correction'] ?? [];
$grad = $student['graduation'] ?? [];

$mainSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'main');
$coSups = array_filter($student['supervisors'] ?? [], fn($s) => $s['role'] === 'co');

function showDate($date) {
    if (empty($date) || $date === '0000-00-00') return '<span class="text-muted">-</span>';
    return date('d M Y', strtotime($date));
}
function showVal($val) {
    return empty($val) ? '<span class="text-muted">-</span>' : htmlspecialchars($val);
}
?>

<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Students / Detail</div>
        <h1 class="h3"><?= htmlspecialchars($student['name']) ?></h1>
    </div>
    <div class="header-actions">
        <a href="<?= $baseUrl ?>/students/manage" class="btn btn-outline-secondary">Back</a>
        <a href="<?= $baseUrl ?>/students/edit/<?= $student['student_id'] ?>" class="btn btn-primary">Edit Student</a>
    </div>
</div>

<div class="row g-4 animate-fade-in-up stagger-1">
    <!-- Left Column: Quick Summary -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center pt-4">
                <div class="avatar-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    <?= strtoupper(substr($student['name'], 0, 1)) ?>
                </div>
                <h4 class="card-title mb-1"><?= htmlspecialchars($student['name']) ?></h4>
                <p class="text-muted mb-3"><?= htmlspecialchars($student['matric_no']) ?></p>
                <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill">
                    <?= htmlspecialchars($student['research_status']) ?>
                </span>
            </div>
            <ul class="list-group list-group-flush border-top">
                <li class="list-group-item d-flex justify-content-between p-3">
                    <span class="text-muted">Degree</span>
                    <strong><?= htmlspecialchars($student['degree_level']) ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3">
                    <span class="text-muted">School</span>
                    <strong><?= htmlspecialchars($student['school'] ?? '-') ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3">
                    <span class="text-muted">Cohort</span>
                    <strong><?= htmlspecialchars($student['cohort'] ?? '-') ?></strong>
                </li>
            </ul>
        </div>
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">Supervisors</div>
            <div class="card-body">
                <h6 class="text-muted mb-2">Main Supervisor</h6>
                <?php if ($mainSups): ?>
                    <ul class="list-unstyled mb-3">
                        <?php foreach($mainSups as $s): ?>
                            <li><i class="bi bi-person-fill text-primary me-2"></i><?= htmlspecialchars($s['supervisor_name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">-</p>
                <?php endif; ?>

                <h6 class="text-muted mb-2">Co-Supervisors</h6>
                <?php if ($coSups): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach($coSups as $s): ?>
                            <li><i class="bi bi-person text-secondary me-2"></i><?= htmlspecialchars($s['supervisor_name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">-</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Column: Detail Tabs -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <ul class="nav nav-tabs" id="detailTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-info" type="button">Program Info</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-viva" type="button">Panel & Viva</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-corr" type="button">Post-Viva</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-grad" type="button">Graduation</button>
                    </li>
                </ul>
            </div>
            
            <div class="card-body p-4">
                <div class="tab-content">
                    
                    <!-- INFO TAB -->
                    <div class="tab-pane fade show active" id="tab-info">
                        <h5 class="mb-4">Thesis & Submission Info</h5>
                        <table class="table table-borderless table-sm w-100">
                            <tr><td class="text-muted" style="width: 30%;">Thesis Title</td><td><strong><?= showVal($student['thesis_title']) ?></strong></td></tr>
                            <tr><td class="text-muted">Programme</td><td><?= showVal($student['programme']) ?></td></tr>
                            <tr><td class="text-muted">ITS Receipt Date</td><td><?= showDate($student['its_receipt_date']) ?></td></tr>
                            <tr><td class="text-muted">JIL Meeting Date</td><td><?= showDate($grad['jil_meeting_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">JIL Meeting No.</td><td><?= showVal($grad['jil_meeting_no'] ?? null) ?></td></tr>
                            
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fw-bold" colspan="2">Draft Thesis Requirements</td></tr>
                            <tr><td class="text-muted">Submission Email</td><td><?= showDate($viva['thesis_submission_email_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">4 Hard Copy Date</td><td><?= showDate($viva['draft_hard_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Soft Copy Date</td><td><?= showDate($viva['draft_soft_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Turnitin</td><td><?= showVal($viva['turnitin_percentage'] ?? null) ?> %</td></tr>
                            <tr><td class="text-muted">Submission Form Date</td><td><?= showDate($viva['draft_submission_form_date'] ?? null) ?></td></tr>
                        </table>
                    </div>

                    <!-- VIVA TAB -->
                    <div class="tab-pane fade" id="tab-viva">
                        <h5 class="mb-4">Examination Panel & Viva Arrangements</h5>
                        <table class="table table-borderless table-sm">
                            <tr><td class="text-muted" style="width: 35%;">Chairperson</td><td><strong><?= showVal($viva['chairperson_name'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Internal Examiner</td><td><strong><?= showVal($viva['examiner_name'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">External Examiner</td><td><strong><?= showVal($viva['external_examiner_name'] ?? null) ?></strong></td></tr>
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted">Internal Examiner Email Persetujuan</td><td><?= showDate($viva['internal_examiner_email_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">External Examiner Email Persetujuan</td><td><?= showDate($viva['external_examiner_email_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Panel Appointment Letter</td><td><?= showDate($viva['panel_appointment_letter_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Thesis to Panel (Hard)</td><td><?= showDate($viva['thesis_to_panel_hard_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Thesis to Panel (Soft)</td><td><?= showDate($viva['thesis_to_panel_soft_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Confirm Date Email</td><td><?= showDate($viva['confirm_date_email_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Invitation Letter</td><td><?= showDate($viva['invitation_letter_date'] ?? null) ?></td></tr>
                            
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fw-bold" colspan="2">Viva-Voce</td></tr>
                            <tr><td class="text-muted">Viva Date</td><td><strong class="text-primary"><?= showDate($viva['viva_date'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Viva Result</td><td><strong class="text-success"><?= showVal($viva['viva_result'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Internal Report Received</td><td><?= showDate($viva['internal_examiner_report_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Best Thesis Candidate</td><td><?= !empty($viva['best_thesis_candidate']) ? '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Yes</span>' : 'No' ?></td></tr>
                        </table>
                    </div>

                    <!-- CORRECTIONS TAB -->
                    <div class="tab-pane fade" id="tab-corr">
                        <h5 class="mb-4">Post-Viva Corrections & Submission</h5>
                        <table class="table table-borderless table-sm">
                            <tr><td class="text-muted" style="width: 35%;">Correction Deadline</td><td><strong class="text-danger"><?= showDate($corr['correction_deadline'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Reviewed By</td><td><?= showVal($corr['reviewed_by'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Report Sent to Student</td><td><?= showDate($corr['report_sent_to_student_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Internal Report Status</td><td><?= showVal($corr['internal_report_status'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">External Report Status</td><td><?= showVal($corr['external_report_status'] ?? null) ?></td></tr>
                            
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fw-bold" colspan="2">Corrected Thesis Tracking</td></tr>
                            <tr><td class="text-muted">Thesis Received</td><td><?= showDate($corr['corrected_thesis_received_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Checklist After Viva</td><td><?= showDate($corr['checklist_after_viva_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Correction Schedule</td><td><?= showDate($corr['correction_schedule_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Post-Viva Turnitin</td><td><?= showVal($corr['post_viva_turnitin_percentage'] ?? null) ?> %</td></tr>
                            <tr><td class="text-muted">SV Endorsement</td><td><?= showDate($corr['supervisor_endorsement_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Sent to Internal Exam.</td><td><?= showDate($corr['sent_to_internal_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Sent to External Exam.</td><td><?= showDate($corr['sent_to_external_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Sent to Supervisor</td><td><?= showDate($corr['sent_to_supervisor_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Endorsement from Exam.</td><td><?= showDate($corr['endorsement_from_examiner_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Abstract Received</td><td><?= showDate($corr['abstract_received_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Final Result</td><td><strong class="text-success"><?= showVal($corr['final_result'] ?? null) ?></strong></td></tr>
                            
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fw-bold" colspan="2">Honorarium Details</td></tr>
                            <tr><td class="text-muted">Chairperson</td><td><?= showVal($viva['honorarium_chairperson'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Internal Examiner</td><td><?= showVal($viva['honorarium_internal'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">External Examiner</td><td><?= showVal($viva['honorarium_external'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Refreshment</td><td><?= showVal($viva['honorarium_refreshment'] ?? null) ?></td></tr>
                        </table>
                    </div>

                    <!-- GRADUATION TAB -->
                    <div class="tab-pane fade" id="tab-grad">
                        <h5 class="mb-4">Institutional Approvals & Graduation</h5>
                        <table class="table table-borderless table-sm">
                            <tr><td class="text-muted" style="width: 35%;">GAIS Key-in Date</td><td><?= showDate($grad['gais_keyin_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Senate Meeting Date</td><td><?= showDate($grad['senate_meeting_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Senate Meeting No.</td><td><?= showVal($grad['senate_meeting_no'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Senate Status</td><td><strong class="text-primary"><?= showVal($grad['senate_status'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Thesis Certification Date</td><td><?= showDate($grad['thesis_certification_date'] ?? null) ?></td></tr>
                            
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fw-bold" colspan="2">Final Document Submissions</td></tr>
                            <tr><td class="text-muted">Final Thesis Form</td><td><?= showDate($grad['final_thesis_form_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Hard Bound Copies</td><td><?= showDate($grad['hard_bound_copies_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Loose Copy</td><td><?= showDate($grad['loose_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">CD Copies</td><td><?= showDate($grad['cd_copies_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">ETD Form</td><td><?= showDate($grad['etd_form_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Sent to PSB</td><td><?= showDate($grad['sent_to_psb_date'] ?? null) ?></td></tr>
                            
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fs-5">Graduation Date</td><td><strong class="text-success fs-5"><?= showDate($grad['graduation_date'] ?? null) ?></strong></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
