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
    <button type="button" class="btn btn-uum" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus me-1"></i>Add User
    </button>
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

                                <!-- Reset Password Button -->
                                <?php if ($u['user_id'] !== $currentUserId): ?>
                                <button type="button" class="btn btn-sm btn-outline-warning" title="Reset Password"
                                        data-bs-toggle="modal" data-bs-target="#resetPasswordModal"
                                        data-user-id="<?= $u['user_id'] ?>"
                                        data-user-name="<?= htmlspecialchars($u['name']) ?>">
                                    <i class="bi bi-key"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="resetPasswordForm" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">
                        <i class="bi bi-key me-2"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        Setting a new password for <strong id="resetUserName"></strong>.
                    </p>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                   placeholder="Min 6 characters" required minlength="6" autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn" title="Show/Hide password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i>Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="<?= $baseUrl ?>/users/store">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="bi bi-person-plus me-2"></i>Add New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="add_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_username" name="username" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label for="add_password" class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="add_password" name="password"
                                   placeholder="Min 6 characters" required minlength="6" autocomplete="new-password">
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="add_password" title="Show/Hide password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add_role" class="form-label">Role</label>
                        <select class="form-select" id="add_role" name="role">
                            <option value="staff" selected>Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-uum">
                        <i class="bi bi-check-circle me-1"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reset Password Modal
    const resetModal = document.getElementById('resetPasswordModal');
    const resetForm = document.getElementById('resetPasswordForm');
    const resetUserName = document.getElementById('resetUserName');
    const resetPasswordInput = document.getElementById('new_password');

    resetModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        resetForm.action = '<?= $baseUrl ?>/users/reset-password/' + button.getAttribute('data-user-id');
        resetUserName.textContent = button.getAttribute('data-user-name');
        resetPasswordInput.value = '';
    });

    // Password visibility toggle (works for all toggle buttons)
    document.querySelectorAll('.toggle-password-btn, #togglePasswordBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target') || 'new_password';
            const input = document.getElementById(targetId);
            input.type = input.type === 'password' ? 'text' : 'password';
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    });
});
</script>

