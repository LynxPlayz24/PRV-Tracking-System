<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$csrf = $_SESSION['csrf_token'] ?? '';
$currentUserId = $_SESSION['user_id'] ?? 0;
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Users</div>
        <h1>Manage Users</h1>
    </div>
</div>

<div class="card shadow-sm border-0 animate-fade-in-up stagger-1">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted fw-semibold">
                    <tr>
                        <th class="px-4 py-3 border-0">Username</th>
                        <th class="py-3 border-0">Name</th>
                        <th class="py-3 border-0">Email</th>
                        <th class="py-3 border-0">Role</th>
                        <th class="py-3 border-0">Joined</th>
                        <th class="px-4 py-3 border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td class="px-4 fw-medium">
                                <?= htmlspecialchars($u['username']) ?>
                                <?php if($u['user_id'] === $currentUserId): ?>
                                    <span class="badge bg-primary ms-1">You</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($u['name']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <?php
                                $badgeClass = match($u['role']) {
                                    'admin' => 'bg-danger',
                                    'staff' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= strtoupper($u['role']) ?></span>
                            </td>
                            <td class="text-muted small">
                                <?= date('d M Y', strtotime($u['created_at'])) ?>
                            </td>
                            <td class="px-4 text-end">
                                <!-- Role Update Form -->
                                <form action="<?= $baseUrl ?>/users/role/<?= $u['user_id'] ?>" method="POST" class="d-inline-block me-1">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <select name="role" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()" <?= $u['user_id'] === $currentUserId ? 'disabled' : '' ?>>
                                        <option value="staff" <?= $u['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                                        <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </form>

                                <!-- Delete Form -->
                                <form action="<?= $baseUrl ?>/users/delete/<?= $u['user_id'] ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this user account permanently?');">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User" <?= $u['user_id'] === $currentUserId ? 'disabled' : '' ?>>
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
