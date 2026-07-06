<!-- Dashboard Content -->
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Dashboard</div>
        <h1>Dashboard Overview</h1>
    </div>
    <div class="header-actions">
        <a href="<?= rtrim($_ENV['APP_URL'] ?? '', '/') ?>/students/create" class="btn btn-uum">
            <i class="bi bi-person-plus me-2"></i>Add New Student
        </a>
    </div>
</div>

<div class="row g-4 mb-4 animate-fade-in-up stagger-1">
    <!-- Stat Card: Total Students -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value"><?= number_format($stats['total_students']) ?></div>
            <div class="stat-label">Total Students</div>
        </div>
    </div>
    
    <!-- Stat Card: Pending Viva -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            <div class="stat-value"><?= number_format($stats['pending_viva']) ?></div>
            <div class="stat-label">Pending Viva</div>
        </div>
    </div>
    
    <!-- Stat Card: Awaiting Corrections -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-danger">
            <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            <div class="stat-value"><?= number_format($stats['awaiting_corrections']) ?></div>
            <div class="stat-label">Awaiting Corrections</div>
        </div>
    </div>
    
    <!-- Stat Card: Ready for Senate -->
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
    <div class="col-lg-7">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-exclamation-circle text-danger me-2"></i>Action Required</h5>
            </div>
            <div class="card-body">
                <?php if (empty($actions)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle text-success fs-1 mb-2 d-block"></i>
                        No immediate actions required.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Student</th>
                                    <th>Task</th>
                                    <th>Date/Deadline</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($actions as $action): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($action['name']) ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($action['matric_no']) ?></div>
                                        </td>
                                        <td><span class="badge bg-<?= $action['color'] ?>-soft text-<?= $action['color'] ?> px-2 py-1 rounded-pill"><?= htmlspecialchars($action['type']) ?></span></td>
                                        <td><span class="text-dark fw-medium"><?= date('d M Y', strtotime($action['date'])) ?></span></td>
                                        <td>
                                            <a href="<?= rtrim($_ENV['APP_URL'] ?? '', '/') ?>/student/<?= $action['student_id'] ?>" class="btn btn-sm btn-light text-primary">View</a>
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
    
    <!-- Pending Responses Table -->
    <div class="col-lg-5">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-hourglass-split text-warning me-2"></i>Pending Responses</h5>
            </div>
            <div class="card-body">
                <?php if (empty($pending)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 mb-2 d-block"></i>
                        No pending responses.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <?php foreach ($pending as $p): ?>
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded p-2 me-3 text-secondary">
                                                    <i class="bi bi-envelope"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($p['name']) ?></div>
                                                    <div class="small text-muted"><?= htmlspecialchars($p['task']) ?></div>
                                                    <div class="small text-muted mt-1"><i class="bi bi-calendar-event me-1"></i>Sent: <?= date('d M Y', strtotime($p['sent_date'])) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= rtrim($_ENV['APP_URL'] ?? '', '/') ?>/student/<?= $p['student_id'] ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Update</a>
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
