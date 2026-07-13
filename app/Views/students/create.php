<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$isEdit = isset($student);
$formAction = $isEdit ? "$baseUrl/students/update/{$student['student_id']}" : "$baseUrl/students/store";

$viva = $student['viva_records'][0] ?? [];
$corr = $student['correction'] ?? [];
$grad = $student['graduation'] ?? [];

$mainSups = [];
$coSups = [];
if ($isEdit && !empty($student['supervisors'])) {
    foreach ($student['supervisors'] as $s) {
        if ($s['role'] === 'main') $mainSups[] = $s['supervisor_id'];
        else $coSups[] = $s['supervisor_id'];
    }
}

// Ensure examiners exists even if empty
$examiners = $examiners ?? [];
$supervisors = $supervisors ?? [];
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Students / <?= $isEdit ? 'Edit' : 'Create' ?></div>
        <h1><?= $isEdit ? 'Edit Student' : 'Add New Student' ?></h1>
    </div>
    <div class="header-actions">
        <a href="<?= $baseUrl ?>/students/manage" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" form="studentForm" class="btn btn-uum">
            <i class="bi bi-save me-2"></i><?= $isEdit ? 'Save Changes' : 'Save Student' ?>
        </button>
    </div>
</div>

<form id="studentForm" method="POST" action="<?= $formAction ?>" class="animate-fade-in-up stagger-1">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="studentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">1. Student Info</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="supervision-tab" data-bs-toggle="tab" data-bs-target="#supervision" type="button" role="tab">2. Supervision</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="viva-tab" data-bs-toggle="tab" data-bs-target="#viva" type="button" role="tab">3. Panel & Viva</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="postviva-tab" data-bs-toggle="tab" data-bs-target="#postviva" type="button" role="tab">4. Post-Viva</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="graduation-tab" data-bs-toggle="tab" data-bs-target="#graduation" type="button" role="tab">5. Graduation</button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="studentTabsContent">
        
        <!-- TAB 1: Student Info -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">Personal & Program Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($student['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Matric Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="matric_no" value="<?= htmlspecialchars($student['matric_no'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Degree Level</label>
                            <select class="form-select" name="degree_level">
                                <?php foreach(['Masters','PhD','DBA'] as $d): ?>
                                <option value="<?= $d ?>" <?= ($student['degree_level'] ?? '') === $d ? 'selected' : '' ?>><?= $d ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Programme</label>
                            <input type="text" class="form-control" name="programme" value="<?= htmlspecialchars($student['programme'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">School</label>
                            <input type="text" class="form-control" name="school" value="<?= htmlspecialchars($student['school'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Thesis/Cohort</label>
                            <input type="text" class="form-control" name="cohort" value="<?= htmlspecialchars($student['cohort'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Research Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="research_status" required>
                                <?php 
                                $statuses = ['Thesis Submitted', 'Examiner Assigned', 'Viva Scheduled', 'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'];
                                foreach($statuses as $rs): ?>
                                <option value="<?= $rs ?>" <?= ($student['research_status'] ?? 'Thesis Submitted') === $rs ? 'selected' : '' ?>><?= $rs ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Thesis Title</label>
                            <textarea class="form-control" name="thesis_title" rows="2"><?= htmlspecialchars($student['thesis_title'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Supervision -->
        <div class="tab-pane fade" id="supervision" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">Supervision & Submission Initiation</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">ITS Receipt Date</label>
                            <input type="date" class="form-control" name="its_receipt_date" value="<?= htmlspecialchars($student['its_receipt_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">JIL Meeting Date</label>
                            <input type="date" class="form-control" name="jil_meeting_date" value="<?= htmlspecialchars($grad['jil_meeting_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">JIL Meeting No.</label>
                            <input type="text" class="form-control" name="jil_meeting_no" value="<?= htmlspecialchars($grad['jil_meeting_no'] ?? '') ?>">
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-md-6">
                            <label class="form-label">Main Supervisor(s)</label>
                            <select class="form-select" name="main_supervisors[]" multiple size="4">
                                <?php foreach($supervisors as $sup): ?>
                                    <option value="<?= $sup['supervisor_id'] ?>" <?= in_array($sup['supervisor_id'], $mainSups) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sup['supervisor_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Hold CTRL/CMD to select multiple</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Co-Supervisor(s)</label>
                            <select class="form-select" name="co_supervisors[]" multiple size="4">
                                <?php foreach($supervisors as $sup): ?>
                                    <option value="<?= $sup['supervisor_id'] ?>" <?= in_array($sup['supervisor_id'], $coSups) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sup['supervisor_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12"><hr></div>
                        <h6>Draft Thesis Requirements</h6>
                        <div class="col-md-4">
                            <label class="form-label">Thesis Submission Email Date</label>
                            <input type="date" class="form-control" name="thesis_submission_email_date" value="<?= htmlspecialchars($viva['thesis_submission_email_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">4 Hard Copy Date</label>
                            <input type="date" class="form-control" name="draft_hard_copy_date" value="<?= htmlspecialchars($viva['draft_hard_copy_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Soft Copy Date</label>
                            <input type="date" class="form-control" name="draft_soft_copy_date" value="<?= htmlspecialchars($viva['draft_soft_copy_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Turnitin (%)</label>
                            <input type="text" class="form-control" name="turnitin_percentage" value="<?= htmlspecialchars($viva['turnitin_percentage'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Draft Submission Form Date</label>
                            <input type="date" class="form-control" name="draft_submission_form_date" value="<?= htmlspecialchars($viva['draft_submission_form_date'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: Panel & Viva -->
        <div class="tab-pane fade" id="viva" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">Examination Panel & Viva-Voce</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Internal Examiner</label>
                            <select class="form-select" name="internal_examiner_id">
                                <option value="">Select Internal Examiner...</option>
                                <?php foreach($examiners as $ex): ?>
                                    <option value="<?= $ex['examiner_id'] ?>" <?= ($viva['internal_examiner_id'] ?? '') == $ex['examiner_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ex['examiner_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">External Examiner</label>
                            <select class="form-select" name="external_examiner_id">
                                <option value="">Select External Examiner...</option>
                                <?php foreach($examiners as $ex): ?>
                                    <option value="<?= $ex['examiner_id'] ?>" <?= ($viva['external_examiner_id'] ?? '') == $ex['examiner_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ex['examiner_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Internal Examiner Approval Email</label>
                            <input type="date" class="form-control" name="internal_examiner_email_date" value="<?= htmlspecialchars($viva['internal_examiner_email_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">External Examiner Approval Email</label>
                            <input type="date" class="form-control" name="external_examiner_email_date" value="<?= htmlspecialchars($viva['external_examiner_email_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Panel Appointment Letter</label>
                            <input type="date" class="form-control" name="panel_appointment_letter_date" value="<?= htmlspecialchars($viva['panel_appointment_letter_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Thesis to Panel (Hard Copy)</label>
                            <input type="date" class="form-control" name="thesis_to_panel_hard_copy_date" value="<?= htmlspecialchars($viva['thesis_to_panel_hard_copy_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Thesis to Panel (Soft Copy)</label>
                            <input type="date" class="form-control" name="thesis_to_panel_soft_copy_date" value="<?= htmlspecialchars($viva['thesis_to_panel_soft_copy_date'] ?? '') ?>">
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-md-4">
                            <label class="form-label">Confirm Date Email</label>
                            <input type="date" class="form-control" name="confirm_date_email_date" value="<?= htmlspecialchars($viva['confirm_date_email_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Invitation Letter</label>
                            <input type="date" class="form-control" name="invitation_letter_date" value="<?= htmlspecialchars($viva['invitation_letter_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Viva Date</label>
                            <input type="date" class="form-control" name="viva_date" value="<?= htmlspecialchars($viva['viva_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chairperson Name</label>
                            <input type="text" class="form-control" name="chairperson_name" value="<?= htmlspecialchars($viva['chairperson_name'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Viva Result</label>
                            <?php 
                                $currentResult = htmlspecialchars($viva['viva_result'] ?? '');
                                $presetOptions = ['Pass', 'Pass with Minor Correction', 'Pass with Major Correction', 'Fail'];
                                $isCustom = $currentResult && !in_array($currentResult, $presetOptions);
                            ?>
                            <select class="form-select mb-2" id="vivaResultSelect" onchange="toggleCustomVivaResult()">
                                <option value="">Select Result...</option>
                                <?php foreach($presetOptions as $opt): ?>
                                    <option value="<?= $opt ?>" <?= ($currentResult === $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                                <option value="custom" <?= $isCustom ? 'selected' : '' ?>>Other (Custom)...</option>
                            </select>
                            <input type="text" class="form-control" name="viva_result" id="vivaResultInput" 
                                   value="<?= $currentResult ?>" 
                                   style="<?= $isCustom ? '' : 'display:none;' ?>" 
                                   placeholder="Enter custom viva result">

                            <script>
                            function toggleCustomVivaResult() {
                                const select = document.getElementById('vivaResultSelect');
                                const input = document.getElementById('vivaResultInput');
                                
                                if (select.value === 'custom') {
                                    input.style.display = 'block';
                                    input.value = '';
                                    input.focus();
                                } else {
                                    input.style.display = 'none';
                                    input.value = select.value;
                                }
                            }
                            </script>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Internal Examiner Report Received</label>
                            <input type="date" class="form-control" name="internal_examiner_report_date" value="<?= htmlspecialchars($viva['internal_examiner_report_date'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: Post-Viva -->
        <div class="tab-pane fade" id="postviva" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">Corrections & Honorarium</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Correction Deadline</label>
                            <input type="date" class="form-control" name="correction_deadline" value="<?= htmlspecialchars($corr['correction_deadline'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reviewed By</label>
                            <input type="text" class="form-control" name="reviewed_by" value="<?= htmlspecialchars($corr['reviewed_by'] ?? '') ?>" placeholder="Internal/External/SV">
                        </div>
                        <div class="col-md-4 d-flex align-items-center mt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="best_thesis_candidate" id="best_thesis_candidate" value="1" <?= !empty($viva['best_thesis_candidate']) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="best_thesis_candidate">Best Thesis Candidate</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Report Sent to Student</label>
                            <input type="date" class="form-control" name="report_sent_to_student_date" value="<?= htmlspecialchars($corr['report_sent_to_student_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Internal Report Status</label>
                            <input type="text" class="form-control" name="internal_report_status" value="<?= htmlspecialchars($corr['internal_report_status'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">External Report Status</label>
                            <input type="text" class="form-control" name="external_report_status" value="<?= htmlspecialchars($corr['external_report_status'] ?? '') ?>">
                        </div>
                        
                        <div class="col-12"><hr></div>
                        <h6>Honorarium Payments</h6>
                        <div class="col-md-3">
                            <label class="form-label">Chairperson</label>
                            <input type="text" class="form-control" name="honorarium_chairperson" value="<?= htmlspecialchars($viva['honorarium_chairperson'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Internal Examiner</label>
                            <input type="text" class="form-control" name="honorarium_internal" value="<?= htmlspecialchars($viva['honorarium_internal'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">External Examiner</label>
                            <input type="text" class="form-control" name="honorarium_external" value="<?= htmlspecialchars($viva['honorarium_external'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Refreshment</label>
                            <input type="text" class="form-control" name="honorarium_refreshment" value="<?= htmlspecialchars($viva['honorarium_refreshment'] ?? '') ?>">
                        </div>
                        
                        <div class="col-12"><hr></div>
                        <h6>Corrected Thesis Submission</h6>
                        <div class="col-md-4">
                            <label class="form-label">Corrected Thesis Received</label>
                            <input type="date" class="form-control" name="corrected_thesis_received_date" value="<?= htmlspecialchars($corr['corrected_thesis_received_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Checklist After Viva</label>
                            <input type="date" class="form-control" name="checklist_after_viva_date" value="<?= htmlspecialchars($corr['checklist_after_viva_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correction Schedule</label>
                            <input type="date" class="form-control" name="correction_schedule_date" value="<?= htmlspecialchars($corr['correction_schedule_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Post-Viva Turnitin (%)</label>
                            <input type="text" class="form-control" name="post_viva_turnitin_percentage" value="<?= htmlspecialchars($corr['post_viva_turnitin_percentage'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Supervisor Endorsement</label>
                            <input type="date" class="form-control" name="supervisor_endorsement_date" value="<?= htmlspecialchars($corr['supervisor_endorsement_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Abstract Received</label>
                            <input type="date" class="form-control" name="abstract_received_date" value="<?= htmlspecialchars($corr['abstract_received_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sent to Internal Examiner</label>
                            <input type="date" class="form-control" name="sent_to_internal_date" value="<?= htmlspecialchars($corr['sent_to_internal_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sent to External Examiner</label>
                            <input type="date" class="form-control" name="sent_to_external_date" value="<?= htmlspecialchars($corr['sent_to_external_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sent to Supervisor</label>
                            <input type="date" class="form-control" name="sent_to_supervisor_date" value="<?= htmlspecialchars($corr['sent_to_supervisor_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Endorsement from Examiner</label>
                            <input type="date" class="form-control" name="endorsement_from_examiner_date" value="<?= htmlspecialchars($corr['endorsement_from_examiner_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Final Result (After Correction)</label>
                            <input type="text" class="form-control" name="final_result" value="<?= htmlspecialchars($corr['final_result'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: Graduation -->
        <div class="tab-pane fade" id="graduation" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">Institutional Approvals & Finalization</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">GAIS Key-in Date</label>
                            <input type="date" class="form-control" name="gais_keyin_date" value="<?= htmlspecialchars($grad['gais_keyin_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Senate Meeting Date</label>
                            <input type="date" class="form-control" name="senate_meeting_date" value="<?= htmlspecialchars($grad['senate_meeting_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Senate Meeting No.</label>
                            <input type="text" class="form-control" name="senate_meeting_no" value="<?= htmlspecialchars($grad['senate_meeting_no'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Senate Status</label>
                            <select class="form-select" name="senate_status">
                                <?php foreach(['Pending','Approved','Rejected'] as $s): ?>
                                    <option value="<?= $s ?>" <?= ($grad['senate_status'] ?? 'Pending') === $s ? 'selected' : '' ?>><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Thesis Certification Date</label>
                            <input type="date" class="form-control" name="thesis_certification_date" value="<?= htmlspecialchars($grad['thesis_certification_date'] ?? '') ?>">
                        </div>
                        
                        <div class="col-12"><hr></div>
                        <h6>Final Submission</h6>
                        <div class="col-md-4">
                            <label class="form-label">Final Thesis Form</label>
                            <input type="date" class="form-control" name="final_thesis_form_date" value="<?= htmlspecialchars($grad['final_thesis_form_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hard Bound Copies</label>
                            <input type="date" class="form-control" name="hard_bound_copies_date" value="<?= htmlspecialchars($grad['hard_bound_copies_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Loose Copy</label>
                            <input type="date" class="form-control" name="loose_copy_date" value="<?= htmlspecialchars($grad['loose_copy_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CD Copies</label>
                            <input type="date" class="form-control" name="cd_copies_date" value="<?= htmlspecialchars($grad['cd_copies_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ETD Form</label>
                            <input type="date" class="form-control" name="etd_form_date" value="<?= htmlspecialchars($grad['etd_form_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sent to PSB</label>
                            <input type="date" class="form-control" name="sent_to_psb_date" value="<?= htmlspecialchars($grad['sent_to_psb_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label">Graduation Date</label>
                            <input type="date" class="form-control" name="graduation_date" value="<?= htmlspecialchars($grad['graduation_date'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentForm');
    if (!form) return;
    
    // Elements
    const vivaDate = form.querySelector('[name="viva_date"]');
    const draftSubmit = form.querySelector('[name="draft_submission_form_date"]');
    const correctionDeadline = form.querySelector('[name="correction_deadline"]');
    const senateMeeting = form.querySelector('[name="senate_meeting_date"]');
    const graduationDate = form.querySelector('[name="graduation_date"]');

    // Helper to show error
    function setError(input, message) {
        input.classList.add('is-invalid');
        let feedback = input.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            input.parentNode.insertBefore(feedback, input.nextSibling);
        }
        feedback.textContent = message;
        feedback.style.display = 'block';
    }

    // Helper to clear error
    function clearError(input) {
        input.classList.remove('is-invalid');
        let feedback = input.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.style.display = 'none';
        }
    }

    // Validation logic
    function validateDates() {
        let isValid = true;
        
        // 1. Viva vs Draft Submit
        if (vivaDate && draftSubmit && vivaDate.value && draftSubmit.value) {
            if (new Date(vivaDate.value) < new Date(draftSubmit.value)) {
                setError(vivaDate, 'Viva Date cannot be earlier than Draft Submission Date.');
                isValid = false;
            } else {
                clearError(vivaDate);
            }
        } else if (vivaDate) { clearError(vivaDate); }

        // 2. Correction Deadline vs Viva
        if (correctionDeadline && vivaDate && correctionDeadline.value && vivaDate.value) {
            if (new Date(correctionDeadline.value) < new Date(vivaDate.value)) {
                setError(correctionDeadline, 'Correction Deadline cannot be earlier than Viva Date.');
                isValid = false;
            } else {
                clearError(correctionDeadline);
            }
        } else if (correctionDeadline) { clearError(correctionDeadline); }

        // 3. Graduation vs Senate
        if (graduationDate && senateMeeting && graduationDate.value && senateMeeting.value) {
            if (new Date(graduationDate.value) < new Date(senateMeeting.value)) {
                setError(graduationDate, 'Graduation Date cannot be earlier than Senate Meeting Date.');
                isValid = false;
            } else {
                clearError(graduationDate);
            }
        } else if (graduationDate) { clearError(graduationDate); }

        return isValid;
    }

    // Bind listeners
    [vivaDate, draftSubmit, correctionDeadline, senateMeeting, graduationDate].forEach(el => {
        if (el) {
            el.addEventListener('change', validateDates);
            el.addEventListener('input', validateDates);
        }
    });

    // Prevent submission if invalid
    form.addEventListener('submit', function(e) {
        if (!validateDates()) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                // If it's in a hidden tab, switch to that tab first
                const tabPane = firstError.closest('.tab-pane');
                if (tabPane && !tabPane.classList.contains('show')) {
                    const tabId = tabPane.id;
                    const tabTrigger = document.querySelector(`[data-bs-target="#${tabId}"]`);
                    if (tabTrigger) {
                        tabTrigger.click();
                        setTimeout(() => firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }), 150);
                        return;
                    }
                }
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>
