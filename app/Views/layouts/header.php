<?php
/**
 * Layout Header - Navbar & HTML Head
 * Included at the top of every authenticated page.
 * 
 * Variables expected:
 *   $pageTitle (string) - Page title
 *   $currentPage (string) - Active sidebar item key
 */

use App\Core\Middleware;

$baseUrl   = rtrim($_ENV['APP_URL'] ?? '', '/');
$userName  = Middleware::userName() ?? 'User';
$userRole  = Middleware::userRole() ?? 'user';
$isAdmin   = Middleware::isAdmin();
$initials  = strtoupper(substr($userName, 0, 1));

// Flash message
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Postgraduate Research & Viva Tracking System - Universiti Utara Malaysia">
    <title><?= htmlspecialchars($pageTitle ?? 'PRVTS') ?> | GSGSG PRVTS - UUM</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= $baseUrl ?>/assets/css/style.css" rel="stylesheet">
    <!-- Flatpickr (date picker dd/mm/yyyy) -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">

    
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 CSS & Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <!-- Global JS Variables -->
    <script>
        <?php
            $parsedUrl = parse_url($baseUrl, PHP_URL_PATH);
            $basePath = $parsedUrl ? rtrim($parsedUrl, '/') : '';
        ?>
        window.APP_URL = "<?= $basePath ?>";
    </script>
</head>
<body>

<!-- ── Navbar ── -->
<nav class="prvts-navbar">
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
    </button>

    <a href="<?= $baseUrl ?>/dashboard" class="navbar-brand">
        <span class="brand-accent">UUM</span>
        <span>GSGSG PRV TRACKING SYSTEM</span>
    </a>

    <div class="navbar-right">
        <!-- User Menu -->
        <div class="dropdown">
            <div class="user-menu" data-bs-toggle="dropdown" role="button">
                <div class="user-avatar"><?= $initials ?></div>
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($userName) ?></div>
                    <div class="user-role"><?= htmlspecialchars($userRole) ?></div>
                </div>
                <i class="bi bi-chevron-down" style="font-size: 0.7rem; opacity: 0.7;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= $baseUrl ?>/profile"><i class="bi bi-person me-2"></i>My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= $baseUrl ?>/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ── Sidebar Overlay (Mobile) ── -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>


