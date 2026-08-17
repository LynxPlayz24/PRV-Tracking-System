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
function showMoney($val) {
    if ($val === null || $val === '' || $val === false) return '<span class="text-muted">-</span>';
    $clean = trim((string)$val);
    if (is_numeric($clean)) {
        return '<span class="fw-medium text-dark">RM ' . number_format((float)$clean, 2) . '</span>';
    }
    return str_starts_with(strtoupper($clean), 'RM') ? '<span class="fw-medium text-dark">' . htmlspecialchars($clean) . '</span>' : '<span class="fw-medium text-dark">RM ' . htmlspecialchars($clean) . '</span>';
}
?>

<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Students / Detail</div>
        <h1 class="h3"><?= htmlspecialchars($student['name']) ?></h1>
    </div>
    <div class="header-actions">
        <a href="<?= $baseUrl ?>/<?= ($_SESSION['user_role'] ?? '') === 'admin' ? 'students/manage' : 'search' ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
            <a href="<?= $baseUrl ?>/students/edit/<?= $student['student_id'] ?>" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i>Edit Student
            </a>
        <?php endif; ?>
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
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <span class="text-muted flex-shrink-0 me-2">Degree</span>
                    <strong class="text-end"><?= showVal($student['degree_level'] ?? null) ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <span class="text-muted flex-shrink-0 me-2">School</span>
                    <strong class="text-end"><?= htmlspecialchars($student['school'] ?? '-') ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <span class="text-muted flex-shrink-0 me-2">Cohort</span>
                    <strong class="text-end"><?= htmlspecialchars($student['cohort'] ?? '-') ?></strong>
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
                    <li class="nav-item">
                        <button class="nav-link" id="remarks-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-remarks" type="button">
                            <i class="bi bi-chat-left-text me-1"></i>Remarks (<?= count($remarks ?? []) ?>)
                        </button>
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
                            <tr><td class="text-muted">ITS Application Date</td><td><?= showDate($student['its_receipt_date']) ?></td></tr>
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
                            <?php
                                // Extract examiners from junction table data
                                $intExaminers = array_filter($student['examiners'] ?? [], fn($e) => $e['role'] === 'Internal');
                                $extExaminers = array_filter($student['examiners'] ?? [], fn($e) => $e['role'] === 'External');
                                $intNames = implode(', ', array_column(array_values($intExaminers), 'examiner_name'));
                                $extNames = implode(', ', array_column(array_values($extExaminers), 'examiner_name'));
                                // For email/status use viva_records (single slot legacy fields)
                            ?>
                            <tr><td class="text-muted" style="width: 35%;">Chairperson</td><td><strong><?= showVal($viva['chairperson_name'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Internal Examiner</td><td><strong><?= $intNames ? htmlspecialchars($intNames) : '<span class="text-muted">-</span>' ?></strong></td></tr>
                            <tr><td class="text-muted">External Examiner</td><td><strong><?= $extNames ? htmlspecialchars($extNames) : '<span class="text-muted">-</span>' ?></strong></td></tr>
                            <tr><td colspan="2"><hr></td></tr>
                            <?php foreach($intExaminers as $ex): ?>
                            <tr><td class="text-muted">Internal Examiner Confirmation Email<br><small class="text-secondary"><?= htmlspecialchars($ex['examiner_name']) ?></small></td><td>
                                <?= showDate($ex['email_date'] ?? null) ?>
                                <?php if(!empty($ex['email_date'])): ?>
                                    <span class="badge bg-<?= ($ex['status'] ?? '') == 'Confirmed' ? 'success' : 'warning text-dark' ?> ms-2">
                                        <?= htmlspecialchars($ex['status'] ?? 'Pending') ?>
                                    </span>
                                <?php endif; ?>
                            </td></tr>
                            <?php endforeach; ?>
                            <?php if(empty($intExaminers)): ?>
                            <tr><td class="text-muted">Internal Examiner Confirmation Email</td><td><span class="text-muted">-</span></td></tr>
                            <?php endif; ?>
                            <?php foreach($extExaminers as $ex): ?>
                            <tr><td class="text-muted">External Examiner Confirmation Email<br><small class="text-secondary"><?= htmlspecialchars($ex['examiner_name']) ?></small></td><td>
                                <?= showDate($ex['email_date'] ?? null) ?>
                                <?php if(!empty($ex['email_date'])): ?>
                                    <span class="badge bg-<?= ($ex['status'] ?? '') == 'Confirmed' ? 'success' : 'warning text-dark' ?> ms-2">
                                        <?= htmlspecialchars($ex['status'] ?? 'Pending') ?>
                                    </span>
                                <?php endif; ?>
                            </td></tr>
                            <?php endforeach; ?>
                            <?php if(empty($extExaminers)): ?>
                            <tr><td class="text-muted">External Examiner Confirmation Email</td><td><span class="text-muted">-</span></td></tr>
                            <?php endif; ?>
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

                        <?php if (!empty($viva['reviva_date']) || !empty($viva['reviva_result'])): ?>
                        <hr>
                        <h6 class="text-warning mt-3 mb-3"><i class="bi bi-arrow-repeat me-2"></i>Re-viva Session & Outcome</h6>
                        <table class="table table-borderless table-sm">
                            <?php if (!empty($viva['reviva_internal_examiner_name'])): ?>
                            <tr><td class="text-muted" style="width: 35%;">Re-viva Internal Examiner</td><td><strong><?= showVal($viva['reviva_internal_examiner_name'] ?? null) ?></strong></td></tr>
                            <?php endif; ?>
                            <?php if (!empty($viva['reviva_external_examiner_name'])): ?>
                            <tr><td class="text-muted">Re-viva External Examiner</td><td><strong><?= showVal($viva['reviva_external_examiner_name'] ?? null) ?></strong></td></tr>
                            <?php endif; ?>
                            <tr><td class="text-muted">Panel Appointment Letter</td><td><?= showDate($viva['reviva_panel_appointment_letter_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Thesis to Panel (Hard)</td><td><?= showDate($viva['reviva_thesis_to_panel_hard_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Thesis to Panel (Soft)</td><td><?= showDate($viva['reviva_thesis_to_panel_soft_copy_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Confirm Date Email</td><td><?= showDate($viva['reviva_confirm_date_email_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Invitation Letter</td><td><?= showDate($viva['reviva_invitation_letter_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Chairperson</td><td><strong><?= showVal($viva['reviva_chairperson_name'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Re-viva Date</td><td><strong class="text-primary"><?= showDate($viva['reviva_date'] ?? null) ?></strong></td></tr>
                            <tr><td class="text-muted">Re-viva Result</td><td><strong class="text-success"><?= showVal($viva['reviva_result'] ?? null) ?></strong></td></tr>
                        </table>
                        <?php endif; ?>
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
                            <tr><td class="text-muted">COLGIS JIL Meeting Date</td><td><?= showDate($corr['colgis_jil_meeting_date'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">COLGIS JIL Meeting No.</td><td><?= showVal($corr['colgis_jil_meeting_no'] ?? null) ?></td></tr>
                            <tr><td class="text-muted">Final Result</td><td><strong class="text-success"><?= showVal($corr['final_result'] ?? null) ?></strong></td></tr>
                            
                            <?php
                                $chairNameStr = $viva['chairperson_name'] ?? '';
                                $roleLabels = ['Chairperson' => 'Chairperson', 'Internal' => 'Internal Examiner', 'External' => 'External Examiner', 'Refreshment' => 'Refreshment'];
                                $roleIcons  = ['Chairperson' => '🪑', 'Internal' => '🔍', 'External' => '🌐', 'Refreshment' => '☕'];
                            ?>
                            <tr><td colspan="2"><hr></td></tr>
                            <tr><td class="text-muted fw-bold" colspan="2">Honorarium Details</td></tr>
                            <?php if (!empty($honorariumPayments)): ?>
                                <?php foreach ($honorariumPayments as $hp): ?>
                                    <?php
                                        $roleLabel = $roleLabels[$hp['role']] ?? $hp['role'];
                                        $staffLabel = !empty($hp['staff_name']) ? htmlspecialchars($hp['staff_name']) : (!empty($chairNameStr) && $hp['role'] === 'Chairperson' ? htmlspecialchars($chairNameStr) : null);
                                        $displayLabel = $roleLabel . ($staffLabel ? ' (' . $staffLabel . ')' : '');
                                        $pDate = !empty($hp['payment_date']) ? date('d/m/Y', strtotime($hp['payment_date'])) : null;
                                    ?>
                                    <tr>
                                        <td class="text-muted"><?= $displayLabel ?></td>
                                        <td>
                                            <?= showMoney($hp['amount']) ?>
                                            <?php if ($pDate): ?>
                                                <span class="ms-2 text-muted small"><i class="bi bi-calendar-check me-1"></i><?= $pDate ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="2" class="text-muted fst-italic small">No honorarium recorded yet.</td></tr>
                            <?php endif; ?>
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

                    <!-- REMARKS TAB -->
                    <div class="tab-pane fade" id="tab-remarks">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0"><i class="bi bi-chat-square-dots me-2 text-primary"></i>Student Remarks & Attachments</h5>
                        </div>

                        <!-- Add Remark Form -->
                        <div class="card bg-light border-0 mb-4 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-success"></i>Add New Remark / File Attachment</h6>
                                <form action="<?= $baseUrl ?>/student/<?= $student['student_id'] ?>/remarks" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="remark_text" rows="3" placeholder="Enter remark notes, feedback, or meeting updates..." required></textarea>
                                    </div>
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-7">
                                            <label class="form-label small text-muted mb-1"><i class="bi bi-paperclip me-1"></i>Attach Media / Document (PDF, Images, DOC, ZIP - max 10MB)</label>
                                            <input type="file" class="form-control form-control-sm" name="attachment">
                                        </div>
                                        <div class="col-md-5 text-md-end pt-md-3">
                                            <button type="submit" class="btn btn-uum btn-sm px-4">
                                                <i class="bi bi-send me-1"></i> Post Remark
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Remarks List -->
                        <?php if (empty($remarks)): ?>
                            <div class="text-center text-muted py-4 border rounded bg-white">
                                <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                                No remarks recorded yet for this student.
                            </div>
                        <?php else: ?>
                            <div class="timeline position-relative ps-2">
                                <?php foreach ($remarks as $rem): ?>
                                    <div class="card border shadow-sm mb-3 position-relative">
                                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-2 px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-2 fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem; line-height:32px; text-align:center; border-radius:50%;">
                                                    <?= strtoupper(substr($rem['author_name'] ?? 'S', 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark me-2"><?= htmlspecialchars($rem['author_name']) ?></span>
                                                    <span class="small text-muted"><i class="bi bi-clock me-1"></i><?= date('d M Y, h:i A', strtotime($rem['created_at'])) ?></span>
                                                </div>
                                            </div>
                                            <form action="<?= $baseUrl ?>/student/<?= $student['student_id'] ?>/remarks/delete/<?= $rem['remark_id'] ?>" method="POST" onsubmit="return confirm('Delete this remark and its attachment?');">
                                                <button type="submit" class="btn btn-sm text-danger p-0 border-0" title="Delete Remark">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body py-3 px-3">
                                            <p class="card-text mb-2 text-dark" style="white-space: pre-wrap;"><?= htmlspecialchars($rem['remark_text']) ?></p>

                                            <?php if (!empty($rem['file_path'])): ?>
                                                <?php 
                                                $fileExt = strtolower(pathinfo($rem['file_name'], PATHINFO_EXTENSION));
                                                $iconClass = match($fileExt) {
                                                    'pdf' => 'bi-file-earmark-pdf text-danger',
                                                    'doc', 'docx' => 'bi-file-earmark-word text-primary',
                                                    'jpg', 'jpeg', 'png', 'gif' => 'bi-file-earmark-image text-success',
                                                    'zip' => 'bi-file-earmark-zip text-warning',
                                                    'xlsx', 'csv' => 'bi-file-earmark-excel text-success',
                                                    default => 'bi-file-earmark-text text-secondary'
                                                };
                                                $fileUrl = $baseUrl . '/' . $rem['file_path'];
                                                $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                                                ?>
                                                <div class="mt-3 p-2 bg-light rounded border d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center overflow-hidden">
                                                        <i class="bi <?= $iconClass ?> fs-4 me-2"></i>
                                                        <div class="text-truncate">
                                                            <a href="<?= $fileUrl ?>" target="_blank" class="fw-semibold text-decoration-none text-dark">
                                                                <?= htmlspecialchars($rem['file_name']) ?>
                                                            </a>
                                                            <div class="small text-muted">
                                                                <?= !empty($rem['file_size']) ? round($rem['file_size'] / 1024, 1) . ' KB' : '' ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="<?= $fileUrl ?>" download="<?= htmlspecialchars($rem['file_name']) ?>" class="btn btn-sm btn-outline-secondary ms-3">
                                                        <i class="bi bi-download me-1"></i> Download
                                                    </a>
                                                </div>

                                                <?php if ($isImage): ?>
                                                    <div class="mt-2 text-center">
                                                        <a href="<?= $fileUrl ?>" target="_blank">
                                                            <img src="<?= $fileUrl ?>" alt="Attachment" class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: contain;">
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let hash = window.location.hash;
    if (hash) {
        let triggerEl = document.querySelector('button[data-bs-target="' + hash + '"]');
        if (triggerEl) {
            let tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Auto-show creation confirmation modal
    if (new URLSearchParams(window.location.search).get('created') === '1') {
        var modal = new bootstrap.Modal(document.getElementById('studentCreatedModal'));
        modal.show();
        // Clean URL without reload
        history.replaceState(null, '', window.location.pathname + window.location.hash);
    }
});
</script>

<?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
<!-- Student Created Confirmation Modal -->
<div class="modal fade" id="studentCreatedModal" tabindex="-1" aria-labelledby="studentCreatedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center px-4 py-5">
                <div class="mb-3" style="font-size: 3.5rem; color: var(--bs-success);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h5 class="fw-bold mb-1" id="studentCreatedModalLabel">Student Added Successfully</h5>
                <p class="text-muted mb-1"><?= htmlspecialchars($student['name']) ?></p>
                <p class="text-muted small mb-4"><?= htmlspecialchars($student['matric_no']) ?> &mdash; <?= htmlspecialchars($student['research_status']) ?></p>
                <div class="d-flex flex-column gap-2">
                    <a href="<?= $baseUrl ?>/students/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add Another Student
                    </a>
                    <a href="<?= $baseUrl ?>/students/manage" class="btn btn-outline-secondary">
                        <i class="bi bi-table me-1"></i>Manage All Students
                    </a>
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">
                        Stay on This Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
