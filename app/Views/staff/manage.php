<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$csrf = $_SESSION['csrf_token'] ?? '';
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Academic Staff</div>
        <h1>Manage Academic Staff</h1>
    </div>
</div>

<div class="animate-fade-in-up stagger-1">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="staffTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-medium" id="supervisors-tab" data-bs-toggle="tab" data-bs-target="#supervisors" type="button" role="tab">
                <i class="bi bi-person-badge me-2"></i>Supervisors
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-medium" id="examiners-tab" data-bs-toggle="tab" data-bs-target="#examiners" type="button" role="tab">
                <i class="bi bi-briefcase me-2"></i>Examiners
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="staffTabsContent">
        
        <!-- ==============================
             SUPERVISORS TAB
             ============================== -->
        <div class="tab-pane fade show active" id="supervisors" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="position-relative" style="min-width: 280px;">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted" style="left: 12px;"></i>
                    <input type="text" class="form-control ps-5" id="searchSupervisors" placeholder="Search supervisors..." autocomplete="off">
                </div>
                <button class="btn btn-uum" data-bs-toggle="modal" data-bs-target="#addSupervisorModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Supervisor
                </button>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted fw-semibold">
                                <tr>
                                    <th class="px-4 py-3 border-0">Name</th>
                                    <th class="py-3 border-0">Email</th>
                                    <th class="py-3 border-0">Department</th>
                                    <th class="px-4 py-3 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($supervisors)): ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No supervisors found.</td></tr>
                                <?php else: ?>
                                    <?php foreach($supervisors as $sup): ?>
                                    <tr>
                                        <td class="px-4 fw-medium"><?= htmlspecialchars($sup['supervisor_name']) ?></td>
                                        <td><?= htmlspecialchars($sup['email'] ?: '-') ?></td>
                                        <td><?= htmlspecialchars($sup['department'] ?: '-') ?></td>
                                        <td class="px-4 text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1" title="Edit" 
                                                data-bs-toggle="modal" data-bs-target="#editSupervisorModal<?= $sup['supervisor_id'] ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="<?= $baseUrl ?>/staff/supervisors/delete/<?= $sup['supervisor_id'] ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this supervisor permanently?');">
                                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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

            <!-- Edit Supervisor Modals (outside the table for correct rendering) -->
            <?php if (!empty($supervisors)): ?>
                <?php foreach($supervisors as $sup): ?>
                <div class="modal fade" id="editSupervisorModal<?= $sup['supervisor_id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="<?= $baseUrl ?>/staff/supervisors/update/<?= $sup['supervisor_id'] ?>" method="POST" class="modal-content bg-white">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Supervisor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="supervisor_name" value="<?= htmlspecialchars($sup['supervisor_name']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($sup['email']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <input type="text" class="form-control" name="department" value="<?= htmlspecialchars($sup['department']) ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-uum">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ==============================
             EXAMINERS TAB
             ============================== -->
        <div class="tab-pane fade" id="examiners" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="position-relative" style="min-width: 280px;">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted" style="left: 12px;"></i>
                    <input type="text" class="form-control ps-5" id="searchExaminers" placeholder="Search examiners..." autocomplete="off">
                </div>
                <button class="btn btn-uum" data-bs-toggle="modal" data-bs-target="#addExaminerModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Examiner
                </button>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted fw-semibold">
                                <tr>
                                    <th class="px-4 py-3 border-0">Name</th>
                                    <th class="py-3 border-0">Email</th>
                                    <th class="py-3 border-0">Institution</th>
                                    <th class="px-4 py-3 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($examiners)): ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No examiners found.</td></tr>
                                <?php else: ?>
                                    <?php foreach($examiners as $ex): ?>
                                    <tr>
                                        <td class="px-4 fw-medium"><?= htmlspecialchars($ex['examiner_name']) ?></td>
                                        <td><?= htmlspecialchars($ex['email'] ?: '-') ?></td>
                                        <td><?= htmlspecialchars($ex['institution'] ?: '-') ?></td>
                                        <td class="px-4 text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1" title="Edit" 
                                                data-bs-toggle="modal" data-bs-target="#editExaminerModal<?= $ex['examiner_id'] ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="<?= $baseUrl ?>/staff/examiners/delete/<?= $ex['examiner_id'] ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this examiner permanently?');">
                                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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

            <!-- Edit Examiner Modals (outside the table for correct rendering) -->
            <?php if (!empty($examiners)): ?>
                <?php foreach($examiners as $ex): ?>
                <div class="modal fade" id="editExaminerModal<?= $ex['examiner_id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="<?= $baseUrl ?>/staff/examiners/update/<?= $ex['examiner_id'] ?>" method="POST" class="modal-content bg-white">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Examiner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="examiner_name" value="<?= htmlspecialchars($ex['examiner_name']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($ex['email']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Institution</label>
                                    <input type="text" class="form-control" name="institution" value="<?= htmlspecialchars($ex['institution']) ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-uum">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ==============================
     GLOBAL ADD MODALS
     ============================== -->

<!-- Add Supervisor Modal -->
<div class="modal fade" id="addSupervisorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/supervisors/store" method="POST" class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title">Add New Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="supervisor_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" name="department">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-uum">Save Supervisor</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Examiner Modal -->
<div class="modal fade" id="addExaminerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/examiners/store" method="POST" class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title">Add New Examiner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="examiner_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Institution</label>
                    <input type="text" class="form-control" name="institution">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-uum">Save Examiner</button>
            </div>
        </form>
    </div>
</div>

<!-- Simple script to retain active tab on reload if redirected via hash -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Retain active tab on reload
    let hash = window.location.hash;
    if (hash) {
        let triggerEl = document.querySelector('button[data-bs-target="' + hash + '"]');
        if (triggerEl) {
            let tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Live search filtering
    function setupSearch(inputId, tableSelector) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll(tableSelector + ' tbody tr');
            rows.forEach(function(row) {
                // Skip the "no results" placeholder row
                if (row.querySelector('td[colspan]')) return;
                const cells = row.querySelectorAll('td:not(:last-child)');
                let text = '';
                cells.forEach(function(cell) { text += cell.textContent.toLowerCase() + ' '; });
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    setupSearch('searchSupervisors', '#supervisors table');
    setupSearch('searchExaminers', '#examiners table');
});
</script>
