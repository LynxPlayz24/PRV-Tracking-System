<?php
/**
 * Login Page
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
    <meta name="description" content="Login to PRVTS - Postgraduate Research & Viva Tracking System">
    <title>Login | PRVTS - UUM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <div style="width:60px;height:60px;background:var(--uum-yellow);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-mortarboard-fill" style="font-size:1.75rem;color:var(--uum-blue);"></i>
                </div>
                <h2>PRVTS</h2>
                <p>Postgraduate Research & Viva Tracking System</p>
                <p style="font-size:0.75rem;color:var(--gray-400);">Ghazali Shafie Graduate School of Government - UUM</p>
            </div>

            <!-- Flash Message -->
            <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert" style="font-size:0.85rem;">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:0.7rem;"></button>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="<?= $baseUrl ?>/login" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token']) ?>">

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Enter your username" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Enter your password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size:0.85rem;">Remember Me</label>
                    </div>
                    <a href="<?= $baseUrl ?>/forgot-password" style="font-size:0.85rem;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-uum">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const pwd = document.getElementById('password');
        const icon = this.querySelector('i');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pwd.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
    </script>
</body>
</html>
