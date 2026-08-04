<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

$availableFields = [
    'matric_no'       => 'Matric Number',
    'name'            => 'Student Name',
    'programme'       => 'Programme',
    'school'          => 'School / Department',
    'degree_level'    => 'Degree Level',
    'viva_date'       => 'Viva Date',
    'viva_result'     => 'Viva Result',
    'research_status' => 'Current Status'
];
?>

<style>
/* ── Export Page ─────────────────────────────────────────────── */
.export-sidebar .card { border-radius: 12px; overflow: hidden; }
.export-sidebar .card-header { border-bottom: 1px solid rgba(0,0,0,.07); }

.filter-label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #64748b; margin-bottom: .3rem; }

.field-list-item {
    display: flex; align-items: center; gap: .6rem;
    padding: .45rem .6rem; border-radius: 8px; cursor: pointer;
    transition: background .15s;
}
.field-list-item:hover { background: #f1f5f9; }
.field-list-item input[type=checkbox] { width: 16px; height: 16px; flex-shrink: 0; cursor: pointer; accent-color: #2563eb; }
.field-list-item span { font-size: .85rem; color: #334155; }

.preview-card { border: 1.5px solid #2563eb; border-radius: 12px; background: #f8faff; }
.preview-header { background: linear-gradient(90deg,#1e40af,#2563eb); color: #fff; border-radius: 10px 10px 0 0; padding: .75rem 1.2rem; display: flex; align-items: center; justify-content: space-between; }
.preview-header h6 { margin: 0; font-size: .9rem; font-weight: 700; letter-spacing: .02em; }
.preview-meta { display: flex; align-items: center; gap: .5rem; }
.preview-meta .badge-count { background: rgba(255,255,255,.25); color: #fff; border-radius: 20px; padding: .3rem .8rem; font-size: .75rem; font-weight: 600; }
.preview-meta .badge-preview { background: rgba(255,255,255,.15); color: rgba(255,255,255,.85); border-radius: 20px; padding: .3rem .8rem; font-size: .72rem; }

.student-table-card { border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
.student-table-card .card-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: .85rem 1.2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem; }
#exportTable thead th { background: #f8faff; font-size: .76rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 2px solid #e2e8f0; padding: .75rem 1rem; }
#exportTable tbody td { padding: .65rem 1rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: .875rem; }
#exportTable tbody tr:last-child td { border-bottom: none; }
#exportTable tbody tr:hover { background: #f8faff; }

.btn-export-single { padding: .2rem .55rem; font-size: .72rem; border-radius: 6px; line-height: 1.4; white-space: nowrap; }
.export-action-group { display: flex; gap: .3rem; }

.section-divider { display: flex; align-items: center; gap: .75rem; margin: .25rem 0 .75rem; }
.section-divider span { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #94a3b8; white-space: nowrap; }
.section-divider::before, .section-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

.bulk-btn-row { display: flex; gap: .5rem; flex-wrap: wrap; }
</style>

<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Export Data</div>
        <h1>Report Builder &amp; Export</h1>
    </div>
</div>

<div class="row g-4 animate-fade-in-up stagger-1">

    <!-- ══ LEFT SIDEBAR ══════════════════════════════════════════ -->
    <div class="col-lg-4 export-sidebar">
        <form method="POST" action="<?= $baseUrl ?>/export/custom" id="reportBuilderForm" target="_blank">

            <!-- Filters card -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-funnel-fill text-primary me-2"></i>Filters</h6>
                    <a href="<?= $baseUrl ?>/export" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </a>
                </div>
                <div class="card-body bg-light py-3">

                    <div class="mb-3">
                        <label class="filter-label">School / Department</label>
                        <select name="school[]" class="form-select select2-multiple" multiple data-placeholder="All Schools">
                            <?php foreach($schools as $sch): ?>
                                <option value="<?= htmlspecialchars($sch) ?>" <?= in_array($sch, (array)$filters['school']) ? 'selected' : '' ?>><?= htmlspecialchars($sch) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="filter-label">Programme</label>
                        <select name="programme[]" class="form-select select2-multiple" multiple data-placeholder="All Programmes">
                            <?php foreach($programmes as $prog): ?>
                                <option value="<?= htmlspecialchars($prog) ?>" <?= in_array($prog, (array)$filters['programme']) ? 'selected' : '' ?>><?= htmlspecialchars($prog) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="filter-label">Degree Level</label>
                        <select name="degree_level[]" class="form-select select2-multiple" multiple data-placeholder="All Levels">
                            <?php 
                            $degreeOptions = [
                                'Diploma', 'Advanced Diploma', 'Postdoctoral', 'Associate Degree', 
                                'APEL 7', 'Mobility', 'Program Upgrade', "Bachelor's Degree", 
                                'Postgraduate Diploma', 'Masters', 'PhD', 'DBA', 
                                'Certificate', 'Higher National Diploma', 'Executive Diploma'
                            ];
                            foreach ($degreeOptions as $d): ?>
                            <option value="<?= $d ?>" <?= in_array($d, (array)$filters['degree_level']) ? 'selected' : '' ?>><?= $d ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="filter-label">Research Status</label>
                        <select name="research_status[]" class="form-select select2-multiple" multiple data-placeholder="All Statuses">
                            <?php
                            $statuses = ['Graduated','Ready for Senate','Corrections Submitted','Viva Completed','Viva Scheduled','Examiner Assigned','Thesis Submitted'];
                            foreach($statuses as $st): ?>
                                <option value="<?= $st ?>" <?= in_array($st, (array)$filters['research_status']) ? 'selected' : '' ?>><?= $st ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="filter-label">Viva Month</label>
                            <select name="month[]" class="form-select select2-multiple" multiple data-placeholder="All Months">
                                <?php foreach($monthNames as $num => $mName): ?>
                                    <option value="<?= $num ?>" <?= in_array($num, (array)$filters['month']) ? 'selected' : '' ?>><?= substr($mName, 0, 3) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="filter-label">Viva Year</label>
                            <select name="year[]" class="form-select select2-multiple" multiple data-placeholder="All Years">
                                <?php foreach($vivaYears as $yr): ?>
                                    <option value="<?= $yr ?>" <?= in_array($yr, (array)$filters['year']) ? 'selected' : '' ?>><?= $yr ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Custom Fields card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-layout-three-columns text-primary me-2"></i>Custom Export Fields</h6>
                </div>
                <div class="card-body py-2 px-3">
                    <?php foreach ($availableFields as $key => $label): ?>
                        <label class="field-list-item w-100">
                            <input class="custom-export-field" type="checkbox" name="fields[]" value="<?= $key ?>"
                                <?= in_array($key, ['matric_no','name','viva_date','research_status']) ? 'checked' : '' ?>>
                            <span><?= $label ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="card-footer bg-white border-top p-3">
                    <button type="submit" class="btn btn-excel-outline w-100 fw-semibold">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export Custom Excel
                    </button>
                </div>
            </div>

        </form>
    </div>

    <!-- ══ RIGHT MAIN AREA ═══════════════════════════════════════ -->
    <div class="col-lg-8">

        <!-- Live Preview -->
        <div class="preview-card shadow-sm mb-4">
            <div class="preview-header">
                <h6><i class="bi bi-eye me-2"></i>Live Custom Report Preview</h6>
                <div class="preview-meta">
                    <span class="badge-count" id="previewMatchCount">— students</span>
                    <span class="badge-preview">Top 3 rows</span>
                </div>
            </div>
            <div class="p-3">
                <div id="previewContainer" style="min-height: 100px; border-radius: 8px; overflow: hidden;">
                    <div class="text-center text-muted py-4 small">Select fields above to generate a live preview.</div>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="student-table-card shadow-sm">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill text-primary"></i>
                    <span class="fw-bold text-dark">Matching Students</span>
                    <span class="badge bg-primary rounded-pill px-3" id="studentCount"><?= count($students ?? []) ?></span>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Search -->
                    <div class="search-container m-0" style="max-width: 210px;">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="exportSearchInput" class="search-input" placeholder="Quick search...">
                        <button id="exportClearBtn" class="search-clear" style="display:none;"><i class="bi bi-x-circle-fill"></i></button>
                    </div>
                    <!-- Bulk exports -->
                    <div class="section-divider" style="width:1px; height:24px; background:#e2e8f0; margin:0;"></div>
                    <button type="button" class="btn btn-uum-outline btn-sm" onclick="submitStandardExport('pdf')">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Bulk PDF
                    </button>
                    <button type="button" class="btn btn-excel-outline btn-sm" onclick="submitStandardExport('excel')">
                        <i class="bi bi-file-earmark-excel me-1"></i>Bulk Excel
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <?php if (empty($students)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 2.5rem; opacity:.4;"></i>
                        <p class="mt-2 mb-0">No students match your selected filter criteria.</p>
                    </div>
                <?php else: ?>

                <div id="exportNoResults" class="text-center text-muted py-4" style="display:none;">
                    <i class="bi bi-search" style="font-size: 2rem; opacity:.4;"></i>
                    <p class="mt-2 mb-0 small">No students match your quick search.</p>
                </div>

                <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                    <table class="table align-middle mb-0" id="exportTable">
                        <thead>
                            <tr>
                                <th class="px-4">Matric No</th>
                                <th>Name / Programme</th>
                                <th>Status</th>
                                <th class="text-center">Export</th>
                            </tr>
                        </thead>
                        <tbody id="exportTableBody">
                            <?php foreach($students as $s): ?>
                            <tr>
                                <td class="px-4 fw-semibold text-dark"><?= htmlspecialchars($s['matric_no']) ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= htmlspecialchars($s['name']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($s['programme'] ?? '—') ?></div>
                                </td>
                                <td>
                                    <?php
                                    $status = $s['research_status'] ?? 'Unknown';
                                    $badgeClass = match($status) {
                                        'Graduated'              => 'badge-graduated',
                                        'Ready for Senate'       => 'badge-ready-senate',
                                        'Corrections Submitted'  => 'badge-corrections-submitted',
                                        'Viva Completed'         => 'badge-viva-completed',
                                        'Viva Scheduled'         => 'badge-viva-scheduled',
                                        'Examiner Assigned'      => 'badge-examiner-assigned',
                                        'Thesis Submitted'       => 'badge-thesis-submitted',
                                        default                  => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge-status <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="export-action-group justify-content-center">
                                        <a href="<?= $baseUrl ?>/export/pdf/<?= $s['student_id'] ?>"
                                           target="_blank"
                                           class="btn btn-uum-outline btn-export-single"
                                           title="Export PDF">
                                            <i class="bi bi-file-earmark-pdf"></i> PDF
                                        </a>
                                        <a href="<?= $baseUrl ?>/export/excel/<?= $s['student_id'] ?>"
                                           class="btn btn-excel-outline btn-export-single"
                                           title="Export Excel">
                                            <i class="bi bi-file-earmark-excel"></i> Excel
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php endif; ?>
            </div>
        </div>

    </div><!-- /col-lg-8 -->
</div>

<script>
// Bulk export mirrors filters from the sidebar form
function submitStandardExport(type) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= $baseUrl ?>/export/' + type;
    form.target = '_blank';

    const filtersForm = document.getElementById('reportBuilderForm');
    const formData = new FormData(filtersForm);

    for (let [key, value] of formData.entries()) {
        if (key !== 'fields[]') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }
    }

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

document.addEventListener('DOMContentLoaded', function() {

    // ── Quick search ──────────────────────────────────────────
    const input    = document.getElementById('exportSearchInput');
    const clearBtn = document.getElementById('exportClearBtn');
    const tbody    = document.getElementById('exportTableBody');
    const noResults= document.getElementById('exportNoResults');
    const countBadge = document.getElementById('studentCount');
    const table    = document.getElementById('exportTable');

    const totalRows = tbody ? tbody.querySelectorAll('tr').length : 0;

    if (input && tbody) {
        input.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            clearBtn.style.display = q ? 'block' : 'none';

            let visible = 0;
            tbody.querySelectorAll('tr').forEach(row => {
                const match = row.textContent.toLowerCase().includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            if (noResults) noResults.style.display = visible === 0 ? '' : 'none';
            if (table)     table.style.display = visible === 0 ? 'none' : '';
            if (countBadge) countBadge.textContent = q
                ? visible + ' (filtered)'
                : totalRows;
        });

        clearBtn?.addEventListener('click', function() {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            input.focus();
        });
    }

    // ── Select2 ───────────────────────────────────────────────
    $('.select2-multiple').select2({ width: '100%', allowClear: true });

    // ── Live Preview ──────────────────────────────────────────
    const previewContainer = document.getElementById('previewContainer');
    const previewMatchCount = document.getElementById('previewMatchCount');
    let fetchTimeout;

    function updatePreview() {
        const formData = new FormData(document.getElementById('reportBuilderForm'));
        const selectedFields = formData.getAll('fields[]');

        if (selectedFields.length === 0) {
            previewContainer.innerHTML = '<div class="text-muted text-center py-4 small">Select fields above to generate a live preview.</div>';
            if (previewMatchCount) previewMatchCount.textContent = '— students';
            return;
        }

        previewContainer.innerHTML = '<div class="text-center py-4 text-muted small"><span class="spinner-border spinner-border-sm text-primary me-2"></span>Generating preview…</div>';

        fetch('<?= $baseUrl ?>/export/preview', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.error) {
                previewContainer.innerHTML = `<div class="alert alert-danger m-2 mb-0">${data.error}</div>`;
                return;
            }

            // Update match count badge
            if (previewMatchCount) {
                const n = data.total_matches ?? 0;
                previewMatchCount.textContent = n + (n === 1 ? ' student' : ' students');
            }

            if (data.data.length === 0) {
                previewContainer.innerHTML = '<div class="text-muted text-center py-4 small">No data matches current filters.</div>';
                return;
            }

            let html = '<div class="table-responsive"><table class="table table-sm table-striped mb-0 text-nowrap" style="font-size:.8rem;"><thead class="table-light"><tr>';
            data.headers.forEach(h => { html += `<th class="px-3 py-2">${h}</th>`; });
            html += '</tr></thead><tbody>';
            data.data.forEach(row => {
                html += '<tr>';
                data.fields.forEach(key => {
                    html += `<td class="px-3 text-truncate" style="max-width:180px;">${row[key] || '—'}</td>`;
                });
                html += '</tr>';
            });
            html += '</tbody></table></div>';
            previewContainer.innerHTML = html;
        })
        .catch(() => {
            previewContainer.innerHTML = '<div class="alert alert-danger m-2 mb-0">Error loading preview.</div>';
        });
    }

    function triggerUpdate() {
        clearTimeout(fetchTimeout);
        fetchTimeout = setTimeout(updatePreview, 350);
    }

    document.querySelectorAll('.custom-export-field').forEach(cb => cb.addEventListener('change', triggerUpdate));
    $('.select2-multiple').on('change', triggerUpdate);

    triggerUpdate();
});
</script>
