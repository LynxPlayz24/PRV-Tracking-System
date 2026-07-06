<?php
/**
 * Registration Page
 * Variables: $csrf_token, $flash
 */
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$flash = $data['flash'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register for PRVTS - Postgraduate Research & Viva Tracking System">
    <title>Register | PRVTS - UUM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card" style="max-width:480px;">
            <div class="auth-logo">
                <div style="width:60px;height:60px;background:var(--uum-yellow);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-mortarboard-fill" style="font-size:1.75rem;color:var(--uum-blue);"></i>
                </div>
                <h2>Create Account</h2>
                <p>Register for PRVTS access</p>
            </div>

            <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert" style="font-size:0.85rem;">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:0.7rem;"></button>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= $baseUrl ?>/register" id="registerForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token']) ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" 
                               placeholder="Enter your full name" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-at"></i></span>
                        <input type="text" class="form-control" id="username" name="username"
                               placeholder="Choose a username" required minlength="3">
                    </div>
                    <div class="form-text">At least 3 characters</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Min 6 characters" required minlength="6">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                               placeholder="Re-enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-uum mt-2">
                    <i class="bi bi-person-plus"></i>
                    Create Account
                </button>
            </form>

            <div class="text-center mt-3">
                <span style="font-size:0.85rem;color:var(--gray-500);">
                    Already have an account? <a href="<?= $baseUrl ?>/login">Sign In</a>
                </span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Client-side password match validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const pwd = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        if (pwd !== confirm) {
            e.preventDefault();
            alert('Passwords do not match!');
        }
    });
    </script>
</body>
</html>
