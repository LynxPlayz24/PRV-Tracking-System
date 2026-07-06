<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$csrf = $_SESSION['csrf_token'] ?? '';
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Settings / Profile</div>
        <h1>My Profile</h1>
    </div>
</div>

<div class="row animate-fade-in-up stagger-1">
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body py-5">
                <div class="position-relative d-inline-block mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white fs-1 fw-bold" style="width:120px;height:120px;border:3px solid var(--uum-blue);">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                </div>
                <h4 class="mb-1"><?= htmlspecialchars($user['name']) ?></h4>
                <p class="text-muted mb-2">@<?= htmlspecialchars($user['username']) ?></p>
                <span class="badge bg-secondary"><?= strtoupper($user['role']) ?></span>
                
                <hr class="my-4">
                <div class="text-start">
                    <div class="mb-2"><i class="bi bi-envelope text-muted me-2"></i><?= htmlspecialchars($user['email']) ?></div>
                    <div><i class="bi bi-calendar3 text-muted me-2"></i>Joined <?= date('M Y', strtotime($user['created_at'])) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0"><h5 class="mb-0 fw-bold text-dark">Edit Profile Settings</h5></div>
            <div class="card-body">
                <form action="<?= $baseUrl ?>/profile/update" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    
                    <h6 class="mb-3 text-primary">Basic Information</h6>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>


                    <h6 class="mb-3 text-primary">Change Password</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-uum px-4">
                            <i class="bi bi-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
