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



<style>
.dashboard-alert-scroll {
    max-height: 540px;
    overflow-y: auto;
}
.dashboard-alert-scroll::-webkit-scrollbar {
    width: 6px;
}
.dashboard-alert-scroll::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}
.dashboard-alert-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.dashboard-alert-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
.dashboard-alert-scroll table thead th {
    position: sticky;
    top: 0;
    background-color: #f8fafc !important;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
}
</style>

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
                    <div class="table-responsive dashboard-alert-scroll">
                        <table class="table table-hover align-middle mb-0">
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
                                            <a href="<?= $baseUrl ?>/students/edit/<?= $action['student_id'] ?>?highlight=<?= urlencode($action['highlight'] ?? '') ?>#<?= $action['tab'] ?? '' ?>" class="btn btn-sm btn-outline-primary px-3">
                                                <i class="bi bi-pencil-square me-1"></i> Update Record
                                            </a>
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
                    <div class="table-responsive dashboard-alert-scroll">
                        <table class="table table-hover align-middle mb-0">
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
                                            <a href="<?= $baseUrl ?>/students/edit/<?= $p['student_id'] ?><?= !empty($p['highlight']) ? '?highlight=' . urlencode($p['highlight']) : '' ?>#<?= $p['tab'] ?? '' ?>" class="btn btn-sm btn-outline-primary px-3">
                                                <i class="bi bi-pencil-square me-1"></i> Update Record
                                            </a>
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


