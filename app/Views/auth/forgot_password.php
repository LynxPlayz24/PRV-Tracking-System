<?php
/**
 * Forgot Password Page
 * Directs users to contact their administrator for password resets.
 */
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | PRVTS - UUM</title>
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
                <h2>Forgot Password</h2>
            </div>

            <div class="alert alert-info" role="alert" style="font-size:0.9rem;">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Password resets are managed by your administrator.</strong>
                <hr class="my-2">
                <p class="mb-0">Please contact your system administrator to have your password reset. They can do this from the <strong>User Management</strong> panel.</p>
            </div>

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
