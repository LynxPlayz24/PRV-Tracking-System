<?php
/**
 * Forgot Password / Reset Password Page
 * Variables: $csrf_token, $flash, $token (optional - for reset form)
 */
$baseUrl  = rtrim($_ENV['APP_URL'] ?? '', '/');
$flash    = $data['flash'] ?? null;
$token    = $data['token'] ?? null;
$isReset  = !empty($token);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isReset ? 'Reset Password' : 'Forgot Password' ?> | PRVTS - UUM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div style="width:60px;height:60px;background:var(--uum-yellow);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-key-fill" style="font-size:1.75rem;color:var(--uum-blue);"></i>
                </div>
                <h2><?= $isReset ? 'Reset Password' : 'Forgot Password' ?></h2>
                <p><?= $isReset ? 'Enter your new password below' : 'Enter your email to receive a reset link' ?></p>
            </div>

            <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert" style="font-size:0.85rem;">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:0.7rem;"></button>
            </div>
            <?php endif; ?>

            <?php if ($isReset): ?>
            <!-- Reset Password Form -->
            <form method="POST" action="<?= $baseUrl ?>/reset-password">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token']) ?>">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Min 6 characters" required minlength="6">
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                           placeholder="Re-enter password" required>
                </div>

                <button type="submit" class="btn btn-uum">
                    <i class="bi bi-check-circle"></i>
                    Reset Password
                </button>
            </form>

            <?php else: ?>
            <!-- Forgot Password Form -->
            <form method="POST" action="<?= $baseUrl ?>/forgot-password">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token']) ?>">

                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Enter your registered email" required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn btn-uum">
                    <i class="bi bi-send"></i>
                    Send Reset Link
                </button>
            </form>
            <?php endif; ?>

            <div class="text-center mt-3">
                <a href="<?= $baseUrl ?>/login" style="font-size:0.85rem;">
                    <i class="bi bi-arrow-left me-1"></i>Back to Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
