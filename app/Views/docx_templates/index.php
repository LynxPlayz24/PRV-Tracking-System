<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>

<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Data / Docx Templates</div>
        <h1>Thesis Certification Generator</h1>
    </div>
</div>

<div class="row g-4 animate-fade-in-up stagger-1">
    <!-- Left Column: Student Selection & Form -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-file-earmark-word text-primary me-2"></i>Generate Document
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= $baseUrl ?>/docx-templates/generate" method="POST" target="_blank" id="docxForm">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="template_filename" value="perakuan_kerja_tesis.docx">
                    
                    <!-- Select Student -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Choose Student <span class="text-danger">*</span></label>
                        <select class="form-select select2-search form-select-lg" name="student_id" id="studentSelect" required onchange="onStudentChange(this.value)">
                            <option value="">-- Search / Select Student --</option>
                            <?php foreach ($students as $st): ?>
                                <option value="<?= $st['student_id'] ?>" <?= ($selectedStudent && $selectedStudent['student_id'] == $st['student_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($st['matric_no']) ?> - <?= htmlspecialchars($st['name']) ?> (<?= htmlspecialchars($st['school'] ?? 'N/A') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text mt-2">Select a student from the database to generate their official Thesis Certification Document.</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="btn btn-uum btn-lg w-100 py-3 fw-bold shadow-sm" <?= !$selectedStudent ? 'disabled' : '' ?> id="generateBtn">
                            <i class="bi bi-download me-2"></i>Generate &amp; Download Document (.docx)
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Student Preview Card -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4 bg-white">
            <div class="card-header bg-light py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-person-badge text-primary me-2"></i>Selected Student Preview
                </h5>
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" id="selectedBadge">
                    <?= $selectedStudent ? htmlspecialchars($selectedStudent['matric_no']) : 'No Student Selected' ?>
                </span>
            </div>
            <div class="card-body p-4" id="studentPreviewContainer">
                <?php if ($selectedStudent): ?>
                    <div class="row g-3">
                        <div class="col-6">
                            <span class="text-muted d-block small">Full Name</span>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($selectedStudent['name']) ?></span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block small">Matric Number</span>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($selectedStudent['matric_no']) ?></span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block small">Programme / School</span>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($selectedStudent['programme'] ?? 'N/A') ?> (<?= htmlspecialchars($selectedStudent['school'] ?? 'N/A') ?>)</span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block small">Degree Level</span>
                            <span class="badge bg-info bg-opacity-10 text-info border"><?= htmlspecialchars($selectedStudent['degree_level']) ?></span>
                        </div>
                        <div class="col-12"><hr class="my-2"></div>
                        <div class="col-12">
                            <span class="text-muted d-block small">Thesis Title</span>
                            <span class="fw-semibold text-dark small"><?= htmlspecialchars($selectedStudent['thesis_title'] ?? 'N/A') ?></span>
                        </div>
                        <div class="col-12"><hr class="my-2"></div>
                        <div class="col-6">
                            <span class="text-muted d-block small">Viva Date</span>
                            <span class="fw-semibold text-dark"><?= !empty($selectedStudent['viva_records'][0]['viva_date']) ? htmlspecialchars(strtoupper(date('d M Y', strtotime($selectedStudent['viva_records'][0]['viva_date'])))) : 'Not set' ?></span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block small">Viva Result</span>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($selectedStudent['viva_records'][0]['viva_result'] ?? 'Pending') ?></span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-arrow-left-circle fs-1 text-secondary d-block mb-2"></i>
                        Please select a student from the dropdown menu to preview details and enable document generation.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function onStudentChange(studentId) {
    if (!studentId) return;
    const url = new URL(window.location.href);
    url.searchParams.set('student_id', studentId);
    window.location.href = url.toString();
}
</script>
