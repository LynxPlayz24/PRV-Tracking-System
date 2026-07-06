<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Export Data</div>
        <h1>Generate Student Report</h1>
    </div>
</div>

<div class="card shadow-sm border-0 animate-fade-in-up stagger-1">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark-arrow-down me-2"></i>Select a Student to Generate Report</span>
        <span class="badge bg-secondary" id="studentCount"><?= count($students ?? []) ?> students</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($students)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">No students found. Add students first before exporting.</p>
            </div>
        <?php else: ?>

        <!-- Search Bar & Bulk Actions -->
        <div class="px-4 pt-3 pb-2 d-flex flex-column flex-md-row gap-3 align-items-center justify-content-between">
            <div class="search-container flex-grow-1 m-0" style="max-width: 600px;">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="exportSearchInput" class="search-input" placeholder="Search by name, matric no, programme, or school...">
                <button id="exportClearBtn" class="search-clear" style="display:none;"><i class="bi bi-x-circle-fill"></i></button>
            </div>
            
            <div class="d-flex gap-2">
                <form action="<?= $baseUrl ?>/export/pdf" method="POST" target="_blank" class="m-0">
                    <button type="submit" class="btn btn-uum-outline">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Bulk PDF
                    </button>
                </form>
                <form action="<?= $baseUrl ?>/export/excel" method="POST" target="_blank" class="m-0">
                    <button type="submit" class="btn btn-excel-outline">
                        <i class="bi bi-file-earmark-excel me-1"></i> Bulk Excel
                    </button>
                </form>
            </div>
        </div>

        <!-- No results message -->
        <div id="exportNoResults" class="text-center text-muted py-4" style="display:none;">
            <i class="bi bi-search" style="font-size: 2rem;"></i>
            <p class="mt-2 mb-0">No students match your search.</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="exportTable">
                <thead class="table-light text-muted fw-semibold">
                    <tr>
                        <th class="px-4 py-3 border-0">Matric No</th>
                        <th class="py-3 border-0">Name</th>
                        <th class="py-3 border-0">Programme</th>
                        <th class="py-3 border-0">School</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="px-4 py-3 border-0 text-end">Generate Report</th>
                    </tr>
                </thead>
                <tbody id="exportTableBody">
                    <?php foreach($students as $s): ?>
                    <tr>
                        <td class="px-4 fw-medium"><?= htmlspecialchars($s['matric_no']) ?></td>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td><?= htmlspecialchars($s['programme'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($s['school'] ?? '-') ?></td>
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

        // Show/hide no results message
        if (noResults) noResults.style.display = visibleCount === 0 ? '' : 'none';
        if (table) table.style.display = visibleCount === 0 ? 'none' : '';

        // Update count badge
        if (countBadge) {
            countBadge.textContent = query
                ? visibleCount + ' of ' + totalRows + ' students'
                : totalRows + ' students';
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
