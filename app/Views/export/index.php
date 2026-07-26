<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Export Data</div>
        <h1>Generate Student Report & Export Data</h1>
    </div>
</div>

<!-- Multi-Parameter Filter Card -->
<div class="card shadow-sm border-0 mb-4 animate-fade-in-up">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-funnel-fill text-primary me-2"></i>Filter & Sorting Options</h5>
        <?php if (!empty(array_filter($filters ?? []))): ?>
            <a href="<?= $baseUrl ?>/export" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body bg-light">
        <form method="GET" action="<?= $baseUrl ?>/export" id="exportFilterForm">
            <div class="row g-3">
                <!-- Viva Month Filter -->
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-calendar-month me-1"></i>Viva Month</label>
                    <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Months</option>
                        <?php foreach($monthNames as $num => $mName): ?>
                            <option value="<?= $num ?>" <?= ($filters['month'] ?? '') == $num ? 'selected' : '' ?>><?= $mName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Viva Year Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-calendar3 me-1"></i>Viva Year</label>
                    <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Years</option>
                        <?php foreach($vivaYears as $yr): ?>
                            <option value="<?= $yr ?>" <?= ($filters['year'] ?? '') == $yr ? 'selected' : '' ?>><?= $yr ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- School / Department Filter -->
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-building me-1"></i>School / Department</label>
                    <select name="school" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Schools</option>
                        <?php foreach($schools as $sch): ?>
                            <option value="<?= htmlspecialchars($sch) ?>" <?= ($filters['school'] ?? '') === $sch ? 'selected' : '' ?>><?= htmlspecialchars($sch) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Degree Level Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-award me-1"></i>Degree Level</label>
                    <select name="degree_level" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Levels</option>
                        <option value="Masters" <?= ($filters['degree_level'] ?? '') === 'Masters' ? 'selected' : '' ?>>Masters</option>
                        <option value="PhD" <?= ($filters['degree_level'] ?? '') === 'PhD' ? 'selected' : '' ?>>PhD</option>
                        <option value="DBA" <?= ($filters['degree_level'] ?? '') === 'DBA' ? 'selected' : '' ?>>DBA</option>
                    </select>
                </div>

                <!-- Viva Date Sorting -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-sort-down me-1"></i>Viva Date Sort</label>
                    <select name="sort_viva" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Default (Name)</option>
                        <option value="asc" <?= ($filters['sort_viva'] ?? '') === 'asc' ? 'selected' : '' ?>>Viva Date (Earliest)</option>
                        <option value="desc" <?= ($filters['sort_viva'] ?? '') === 'desc' ? 'selected' : '' ?>>Viva Date (Latest)</option>
                        <option value="month" <?= ($filters['sort_viva'] ?? '') === 'month' ? 'selected' : '' ?>>By Month (Jan-Dec)</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 animate-fade-in-up stagger-1">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark-arrow-down me-2"></i>Select a Student or Export Bulk Reports</span>
        <span class="badge bg-primary px-3 py-2" id="studentCount"><?= count($students ?? []) ?> students found</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($students)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">No students match your selected filter criteria.</p>
                <a href="<?= $baseUrl ?>/export" class="btn btn-sm btn-outline-primary mt-2">Reset Filters</a>
            </div>
        <?php else: ?>

        <!-- Search Bar & Bulk Actions -->
        <div class="px-4 pt-3 pb-2 d-flex flex-column flex-md-row gap-3 align-items-center justify-content-between">
            <div class="search-container flex-grow-1 m-0" style="max-width: 500px;">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="exportSearchInput" class="search-input" placeholder="Search by name, matric no, programme...">
                <button id="exportClearBtn" class="search-clear" style="display:none;"><i class="bi bi-x-circle-fill"></i></button>
            </div>
            
            <div class="d-flex gap-2">
                <!-- Bulk PDF Form -->
                <form action="<?= $baseUrl ?>/export/pdf" method="POST" target="_blank" class="m-0">
                    <?php foreach($filters as $k => $v): ?>
                        <input type="hidden" name="<?= $k ?>" value="<?= htmlspecialchars($v) ?>">
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-uum-outline">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Bulk PDF Export
                    </button>
                </form>

                <!-- Bulk Excel Form -->
                <form action="<?= $baseUrl ?>/export/excel" method="POST" target="_blank" class="m-0">
                    <?php foreach($filters as $k => $v): ?>
                        <input type="hidden" name="<?= $k ?>" value="<?= htmlspecialchars($v) ?>">
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-excel-outline">
                        <i class="bi bi-file-earmark-excel me-1"></i> Bulk Excel Export
                    </button>
                </form>
            </div>
        </div>

        <div id="exportNoResults" class="text-center text-muted py-4" style="display:none;">
            <i class="bi bi-search" style="font-size: 2rem;"></i>
            <p class="mt-2 mb-0">No students match your search term.</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="exportTable">
                <thead class="table-light text-muted fw-semibold">
                    <tr>
                        <th class="px-4 py-3 border-0">Matric No</th>
                        <th class="py-3 border-0">Name</th>
                        <th class="py-3 border-0">School</th>
                        <th class="py-3 border-0">Viva Date</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="px-4 py-3 border-0 text-end">Generate Report</th>
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
                        <td><?= htmlspecialchars($s['school'] ?? '-') ?></td>
                        <td>
                            <?php if (!empty($s['viva_date'])): ?>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-calendar-event me-1 text-primary"></i><?= date('d M Y', strtotime($s['viva_date'])) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
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
                        <td class="px-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= $baseUrl ?>/export/pdf/<?= $s['student_id'] ?>" 
                                   class="btn btn-sm btn-uum-outline" target="_blank" title="Export PDF">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </a>
                                <a href="<?= $baseUrl ?>/export/excel/<?= $s['student_id'] ?>" 
                                   class="btn btn-sm btn-excel-outline" target="_blank" title="Export Excel">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('exportSearchInput');
    const clearBtn = document.getElementById('exportClearBtn');
    const tbody = document.getElementById('exportTableBody');
    const noResults = document.getElementById('exportNoResults');
    const countBadge = document.getElementById('studentCount');
    const table = document.getElementById('exportTable');

    if (!input || !tbody) return;

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
                ? visibleCount + ' of ' + totalRows + ' students'
                : totalRows + ' students found';
        }
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            input.focus();
        });
    }
});
</script>
