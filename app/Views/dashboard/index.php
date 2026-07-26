<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>
<!-- Dashboard Content -->
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Dashboard</div>
        <h1>Dashboard Overview</h1>
    </div>
    <div class="header-actions">
        <a href="<?= $baseUrl ?>/students/create" class="btn btn-uum">
            <i class="bi bi-person-plus me-2"></i>Add New Student
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4 animate-fade-in-up stagger-1">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value"><?= number_format($stats['total_students']) ?></div>
            <div class="stat-label">Total Students</div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            <div class="stat-value"><?= number_format($stats['pending_viva']) ?></div>
            <div class="stat-label">Pending Viva</div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-danger">
            <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            <div class="stat-value"><?= number_format($stats['awaiting_corrections']) ?></div>
            <div class="stat-label">Awaiting Corrections</div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-info">
            <div class="stat-icon"><i class="bi bi-file-earmark-check"></i></div>
            <div class="stat-value"><?= number_format($stats['ready_for_senate']) ?></div>
            <div class="stat-label">Ready for Senate</div>
        </div>
    </div>
</div>

<div class="row g-4 animate-fade-in-up stagger-2">
    <!-- Action Required Table -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-exclamation-circle-fill text-danger me-2"></i>Action Required Alerts
                </h5>
                <span class="badge bg-secondary"><?= count($actions) ?> active</span>
            </div>
            <div class="card-body">
                <?php if (empty($actions)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
                        No immediate actions required!
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small">
                                <tr>
                                    <th>Student</th>
                                    <th>Alert Type</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($actions as $action): ?>
                                    <tr id="alert-row-<?= md5($action['alert_key']) ?>">
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($action['name']) ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($action['matric_no']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $action['badge'] ?> px-2 py-1">
                                                <i class="bi <?= $action['icon'] ?> me-1"></i><?= htmlspecialchars($action['type']) ?>
                                            </span>
                                        </td>
                                        <td><span class="text-dark fw-medium small"><?= date('d M Y', strtotime($action['date'])) ?></span></td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= $baseUrl ?>/student/<?= $action['student_id'] ?>" class="btn btn-outline-primary" title="View Student">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-success resolve-btn" data-key="<?= htmlspecialchars($action['alert_key']) ?>" title="Mark as Done">
                                                    <i class="bi bi-check-lg"></i> Done
                                                </button>
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
    </div>
    
    <!-- Academic Staff Pending Responses Table -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-person-badge-fill text-warning me-2"></i>Academic Staff Pending Responses
                </h5>
                <span class="badge bg-warning text-dark"><?= count($pending) ?> pending</span>
            </div>
            <div class="card-body">
                <?php if (empty($pending)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox-fill text-muted fs-1 mb-2 d-block"></i>
                        No pending responses from Academic Staff.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small">
                                <tr>
                                    <th>Staff & Role</th>
                                    <th>Student & Task</th>
                                    <th>Sent Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending as $p): ?>
                                    <tr id="alert-row-<?= md5($p['alert_key']) ?>">
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($p['staff_name']) ?></div>
                                            <span class="badge bg-light text-primary border small mb-1"><?= htmlspecialchars($p['role']) ?></span>
                                            <?php if (!empty($p['staff_phone'])): ?>
                                                <div class="small">
                                                    <a href="tel:<?= htmlspecialchars($p['staff_phone']) ?>" class="text-decoration-none text-muted">
                                                        <i class="bi bi-telephone me-1 text-success"></i><?= htmlspecialchars($p['staff_phone']) ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark"><?= htmlspecialchars($p['student_name']) ?></div>
                                            <div class="small text-muted mb-1"><?= htmlspecialchars($p['matric_no']) ?></div>
                                            <div class="small text-danger fw-medium"><i class="bi bi-hourglass-split me-1"></i><?= htmlspecialchars($p['task']) ?></div>
                                        </td>
                                        <td>
                                            <span class="small text-muted d-block"><?= date('d M Y', strtotime($p['sent_date'])) ?></span>
                                            <?php 
                                            $days = floor((time() - strtotime($p['sent_date'])) / 86400);
                                            ?>
                                            <span class="badge bg-secondary rounded-pill small"><?= $days ?> days ago</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= $baseUrl ?>/student/<?= $p['student_id'] ?>" class="btn btn-outline-primary" title="Update Student">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-success resolve-btn" data-key="<?= htmlspecialchars($p['alert_key']) ?>" title="Mark as Done">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Resolve / Mark as Done button click handler
    document.querySelectorAll('.resolve-btn').forEach(button => {
        button.addEventListener('click', function() {
            const btn = this;
            const alertKey = btn.getAttribute('data-key');
            if (!alertKey) return;

            const row = btn.closest('tr');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            fetch('<?= $baseUrl ?>/dashboard/alert/resolve', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'alert_key=' + encodeURIComponent(alertKey)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (row) {
                        row.style.transition = 'all 0.4s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        setTimeout(() => row.remove(), 400);
                    }
                } else {
                    alert('Could not resolve alert: ' + (data.message || 'Error occurred'));
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Done';
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-lg"></i> Done';
            });
        });
    });
});
</script>
