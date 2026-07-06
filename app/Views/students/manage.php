<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$csrf = $_SESSION['csrf_token'] ?? '';
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Manage Students</div>
        <h1>Manage Students</h1>
    </div>
    <div class="header-actions">
        <a href="<?= $baseUrl ?>/students/create" class="btn btn-uum">
            <i class="bi bi-person-plus me-2"></i>Add Student
        </a>
    </div>
</div>

<!-- Bulk Action Bar (hidden by default) -->
<div class="alert alert-warning d-flex align-items-center justify-content-between animate-fade-in-up" id="bulkActionBar" style="display: none !important;">
    <div>
        <i class="bi bi-check2-square me-2"></i>
        <strong id="selectedCount">0</strong> student(s) selected
    </div>
    <div>
        <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="btnClearSelection">
            <i class="bi bi-x-lg me-1"></i>Clear Selection
        </button>
        <button type="button" class="btn btn-sm btn-danger" id="btnBulkDelete">
            <i class="bi bi-trash me-1"></i>Delete Selected
        </button>
    </div>
</div>

<!-- Hidden form for bulk delete -->
<form id="bulkDeleteForm" action="<?= $baseUrl ?>/students/bulk-delete" method="POST" style="display:none;">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    <input type="hidden" name="student_ids" id="bulkDeleteIds" value="">
</form>

<div class="card shadow-sm border-0 animate-fade-in-up stagger-1">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="manageTable">
                <thead class="table-light text-muted fw-semibold">
                    <tr>
                        <th class="ps-4 py-3 border-0" style="width: 40px;">
                            <input type="checkbox" class="form-check-input" id="selectAll" title="Select all">
                        </th>
                        <th class="py-3 border-0">Matric No</th>
                        <th class="py-3 border-0">Name</th>
                        <th class="py-3 border-0">Programme</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="px-4 py-3 border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No students found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($students as $s): ?>
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input student-checkbox" value="<?= $s['student_id'] ?>">
                            </td>
                            <td class="font-monospace text-muted"><?= htmlspecialchars($s['matric_no']) ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($s['name']) ?></td>
                            <td><div class="text-truncate" style="max-width:250px;" title="<?= htmlspecialchars($s['programme']) ?>"><?= htmlspecialchars($s['programme'] ?: '-') ?></div></td>
                            <td><?= htmlspecialchars($s['research_status']) ?></td>
                            <td class="px-4 text-end">
                                <a href="<?= $baseUrl ?>/student/<?= $s['student_id'] ?>" class="btn btn-sm btn-outline-info me-1" title="View"><i class="bi bi-eye"></i></a>
                                <a href="<?= $baseUrl ?>/students/edit/<?= $s['student_id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit"><i class="bi bi-pencil"></i></a>
                                
                                <form action="<?= $baseUrl ?>/students/delete/<?= $s['student_id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student? All related records will be destroyed.');">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const bulkBar = document.getElementById('bulkActionBar');
    const selectedCount = document.getElementById('selectedCount');
    const btnClear = document.getElementById('btnClearSelection');
    const btnBulkDelete = document.getElementById('btnBulkDelete');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    const bulkDeleteIds = document.getElementById('bulkDeleteIds');

    function updateBulkBar() {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        const count = checked.length;
        selectedCount.textContent = count;

        if (count > 0) {
            bulkBar.style.setProperty('display', 'flex', 'important');
        } else {
            bulkBar.style.setProperty('display', 'none', 'important');
        }

        // Update "select all" state
        if (checkboxes.length > 0) {
            selectAll.checked = count === checkboxes.length;
            selectAll.indeterminate = count > 0 && count < checkboxes.length;
        }
    }

    // Select All
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateBulkBar();
    });

    // Individual checkboxes
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkBar);
    });

    // Clear Selection
    btnClear.addEventListener('click', function() {
        selectAll.checked = false;
        selectAll.indeterminate = false;
        checkboxes.forEach(cb => cb.checked = false);
        updateBulkBar();
    });

    // Bulk Delete
    btnBulkDelete.addEventListener('click', function() {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        const count = checked.length;

        if (count === 0) return;

        if (!confirm('Are you sure you want to delete ' + count + ' student(s)? All related records will be permanently destroyed.')) {
            return;
        }

        const ids = Array.from(checked).map(cb => cb.value);
        bulkDeleteIds.value = ids.join(',');
        bulkDeleteForm.submit();
    });
});
</script>
