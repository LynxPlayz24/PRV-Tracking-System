<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

$availableFields = [
    'matric_no' => 'Matric Number',
    'name' => 'Student Name',
    'programme' => 'Programme',
    'school' => 'School / Department',
    'degree_level' => 'Degree Level',
    'viva_date' => 'Viva Date',
    'viva_result' => 'Viva Result',
    'research_status' => 'Current Status'
];
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Export Data</div>
        <h1>Report Builder & Export</h1>
    </div>
</div>

<div class="row g-4 animate-fade-in-up stagger-1">
    
    <!-- LEFT SIDEBAR: Filters & Field Selection -->
    <div class="col-lg-4">
        <form method="POST" action="<?= $baseUrl ?>/export/custom" id="reportBuilderForm" target="_blank">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-funnel-fill text-primary me-2"></i>Filters</h5>
                    <a href="<?= $baseUrl ?>/export" class="btn btn-sm btn-outline-secondary">Reset</a>
                </div>
                <div class="card-body bg-light">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">School / Department</label>
                        <select name="school[]" class="form-select select2-multiple" multiple data-placeholder="Select Schools">
                            <?php foreach($schools as $sch): ?>
                                <option value="<?= htmlspecialchars($sch) ?>" <?= in_array($sch, $filters['school'] ?? []) ? 'selected' : '' ?>><?= htmlspecialchars($sch) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Programme</label>
                        <select name="programme[]" class="form-select select2-multiple" multiple data-placeholder="Select Programmes">
                            <?php foreach($programmes as $prog): ?>
                                <option value="<?= htmlspecialchars($prog) ?>" <?= in_array($prog, $filters['programme'] ?? []) ? 'selected' : '' ?>><?= htmlspecialchars($prog) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Degree Level</label>
                        <select name="degree_level[]" class="form-select select2-multiple" multiple data-placeholder="Select Levels">
                            <option value="Masters" <?= in_array('Masters', $filters['degree_level'] ?? []) ? 'selected' : '' ?>>Masters</option>
                            <option value="PhD" <?= in_array('PhD', $filters['degree_level'] ?? []) ? 'selected' : '' ?>>PhD</option>
                            <option value="DBA" <?= in_array('DBA', $filters['degree_level'] ?? []) ? 'selected' : '' ?>>DBA</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Research Status</label>
                        <select name="research_status[]" class="form-select select2-multiple" multiple data-placeholder="Select Statuses">
                            <?php 
                            $statuses = ['Graduated', 'Ready for Senate', 'Corrections Submitted', 'Viva Completed', 'Viva Scheduled', 'Examiner Assigned', 'Thesis Submitted'];
                            foreach($statuses as $st): ?>
                                <option value="<?= $st ?>" <?= in_array($st, $filters['research_status'] ?? []) ? 'selected' : '' ?>><?= $st ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted mb-1">Viva Month</label>
                            <select name="month[]" class="form-select select2-multiple" multiple data-placeholder="Months">
                                <?php foreach($monthNames as $num => $mName): ?>
                                    <option value="<?= $num ?>" <?= in_array($num, $filters['month'] ?? []) ? 'selected' : '' ?>><?= substr($mName, 0, 3) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted mb-1">Viva Year</label>
                            <select name="year[]" class="form-select select2-multiple" multiple data-placeholder="Years">
                                <?php foreach($vivaYears as $yr): ?>
                                    <option value="<?= $yr ?>" <?= in_array($yr, $filters['year'] ?? []) ? 'selected' : '' ?>><?= $yr ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-layout-three-columns text-primary me-2"></i>Select Fields</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush mb-3">
                        <?php foreach ($availableFields as $key => $label): ?>
                            <label class="list-group-item d-flex gap-2 px-1 border-0 py-1">
                                <input class="form-check-input flex-shrink-0 custom-export-field" type="checkbox" name="fields[]" value="<?= $key ?>" <?= in_array($key, ['matric_no', 'name', 'viva_date', 'research_status']) ? 'checked' : '' ?>>
                                <span class="small"><?= $label ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-top p-3 text-end">
                    <button type="submit" class="btn btn-excel-outline w-100">
                        <i class="bi bi-file-earmark-excel me-2"></i>Generate Custom Excel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- RIGHT MAIN AREA: Live Preview & Standard List -->
    <div class="col-lg-8">
        
        <!-- Live Preview Box -->
        <div class="card shadow-sm border-primary mb-4 bg-primary bg-opacity-10" style="border-left: 4px solid #0d6efd !important;">
            <div class="card-header bg-transparent border-bottom-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-eye me-2"></i>Live Custom Report Preview</h6>
                <span class="badge bg-primary rounded-pill">Top 3 Rows</span>
            </div>
            <div class="card-body">
                <div id="previewContainer" class="bg-white border rounded shadow-sm" style="min-height: 120px;">
                    <!-- Preview generated here -->
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 animate-fade-in-up stagger-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-list-ul me-2"></i>Standard Full-Data Views</span>
                <span class="badge bg-secondary px-3 py-2" id="studentCount"><?= count($students ?? []) ?> matching students</span>
            </div>
            <div class="card-body p-0">
                <?php if (empty($students)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2">No students match your selected filter criteria.</p>
                    </div>
                <?php else: ?>

                <!-- Search Bar & Bulk Actions -->
                <div class="px-4 pt-3 pb-2 d-flex flex-column flex-md-row gap-3 align-items-center justify-content-between">
                    <div class="search-container flex-grow-1 m-0" style="max-width: 400px;">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="exportSearchInput" class="search-input" placeholder="Quick search displayed students...">
                        <button id="exportClearBtn" class="search-clear" style="display:none;"><i class="bi bi-x-circle-fill"></i></button>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <!-- Bulk PDF Form -->
                        <button type="button" class="btn btn-uum-outline btn-sm" onclick="submitStandardExport('pdf')">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Standard PDF
                        </button>
                        <!-- Bulk Excel Form -->
                        <button type="button" class="btn btn-excel-outline btn-sm" onclick="submitStandardExport('excel')">
                            <i class="bi bi-file-earmark-excel me-1"></i> Standard Excel
                        </button>
                    </div>
                </div>

                <div id="exportNoResults" class="text-center text-muted py-4" style="display:none;">
                    <i class="bi bi-search" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">No students match your quick search term.</p>
                </div>

                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" id="exportTable">
                        <thead class="table-light text-muted fw-semibold" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th class="px-4 py-3 border-0">Matric No</th>
                                <th class="py-3 border-0">Name / Programme</th>
                                <th class="py-3 border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody id="exportTableBody">
                            <?php foreach($students as $s): ?>
                            <tr>
                                <td class="px-4 fw-medium"><?= htmlspecialchars($s['matric_no']) ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($s['name']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($s['programme'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <?php
                                    $status = $s['research_status'] ?? 'Unknown';
                                    $badgeClass = match($status) {
                                        'Graduated' => 'badge-graduated',
                                        'Ready for Senate' => 'badge-ready-senate',
                                        'Corrections Submitted' => 'badge-corrections-submitted',
                                        'Viva Completed' => 'badge-viva-completed',
                                        'Viva Scheduled' => 'badge-viva-scheduled',
                                        'Examiner Assigned' => 'badge-examiner-assigned',
                                        'Thesis Submitted' => 'badge-thesis-submitted',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge-status <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Hidden forms for standard exports that mirror the filters
function submitStandardExport(type) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= $baseUrl ?>/export/' + type;
    form.target = '_blank';
    
    // Copy all select values from reportBuilderForm
    const filtersForm = document.getElementById('reportBuilderForm');
    const formData = new FormData(filtersForm);
    
    // Create hidden inputs for each filter
    for (let [key, value] of formData.entries()) {
        if (key !== 'fields[]') { // don't send custom fields to standard export
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
    // Quick search logic
    const input = document.getElementById('exportSearchInput');
    const clearBtn = document.getElementById('exportClearBtn');
    const tbody = document.getElementById('exportTableBody');
    const noResults = document.getElementById('exportNoResults');
    const countBadge = document.getElementById('studentCount');
    const table = document.getElementById('exportTable');

    if (input && tbody) {
        const totalRows = tbody.querySelectorAll('tr').length;
        input.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            clearBtn.style.display = query ? 'block' : 'none';

            const rows = tbody.querySelectorAll('tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const match = text.includes(query);
                row.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            if (noResults) noResults.style.display = visibleCount === 0 ? '' : 'none';
            if (table) table.style.display = visibleCount === 0 ? 'none' : '';

            if (countBadge) {
                countBadge.textContent = query
                    ? visibleCount + ' matching students (filtered)'
                    : totalRows + ' matching students';
            }
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                input.value = '';
                input.dispatchEvent(new Event('input'));
                input.focus();
            });
        }
    }

    // Initialize Select2 Multiple
    $('.select2-multiple').select2({
        width: '100%',
        allowClear: true
    });

    // Live Preview Logic
    const fieldCheckboxes = document.querySelectorAll('.custom-export-field');
    const filterSelects = document.querySelectorAll('.select2-multiple');
    const previewContainer = document.getElementById('previewContainer');
    
    let fetchTimeout;

    function updatePreview() {
        const formData = new FormData(document.getElementById('reportBuilderForm'));
        const selectedFields = formData.getAll('fields[]');

        if (selectedFields.length === 0) {
            previewContainer.innerHTML = '<div class="text-muted text-center p-3">Select fields to generate preview.</div>';
            return;
        }

        previewContainer.innerHTML = '<div class="text-center p-4"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Generating live preview...</div>';

        fetch('<?= $baseUrl ?>/export/preview', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                previewContainer.innerHTML = `<div class="alert alert-danger mb-0 m-2">${data.error}</div>`;
                return;
            }

            if (data.data.length === 0) {
                previewContainer.innerHTML = '<div class="text-muted text-center p-4">No data matches current filters.</div>';
                return;
            }

            let html = '<div class="table-responsive mb-0"><table class="table table-sm table-striped mb-0 text-nowrap"><thead class="table-light"><tr>';
            data.headers.forEach(h => {
                html += `<th>${h}</th>`;
            });
            html += '</tr></thead><tbody>';

            data.data.forEach(row => {
                html += '<tr>';
                data.headers.forEach(h => {
                    const key = h.toLowerCase().replace(/ /g, '_');
                    html += `<td class="text-truncate" style="max-width:200px;">${row[key] || '-'}</td>`;
                });
                html += '</tr>';
            });

            html += '</tbody></table></div>';
            previewContainer.innerHTML = html;
        })
        .catch(err => {
            console.error(err);
            previewContainer.innerHTML = '<div class="alert alert-danger mb-0 m-2">Error loading preview.</div>';
        });
    }

    // Debounce updates on filter change
    function triggerUpdate() {
        clearTimeout(fetchTimeout);
        fetchTimeout = setTimeout(updatePreview, 300);
    }

    fieldCheckboxes.forEach(cb => cb.addEventListener('change', triggerUpdate));
    $('.select2-multiple').on('change', triggerUpdate);

    // Initial load
    triggerUpdate();
});
</script>
