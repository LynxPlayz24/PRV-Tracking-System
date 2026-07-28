<?php
/**
 * Layout Sidebar Navigation
 * Role-conditional menu items.
 *
 * Variables expected:
 *   $currentPage (string) - Active menu item key
 */

use App\Core\Middleware;

$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$isAdmin = Middleware::isAdmin();
$current = $currentPage ?? '';
?>

<aside class="prvts-sidebar" id="sidebar">

    <?php if ($isAdmin): ?>
    <!-- ── Admin Navigation ── -->
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="<?= $baseUrl ?>/dashboard" class="nav-link <?= $current === 'dashboard' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Students</div>
        <a href="<?= $baseUrl ?>/search" class="nav-link <?= $current === 'search' ? 'active' : '' ?>">
            <i class="bi bi-search"></i>
            <span>Search Students</span>
        </a>
        <a href="<?= $baseUrl ?>/students/create" class="nav-link <?= $current === 'create' ? 'active' : '' ?>">
            <i class="bi bi-person-plus"></i>
            <span>Add Student</span>
        </a>
        <a href="<?= $baseUrl ?>/students/manage" class="nav-link <?= $current === 'manage' ? 'active' : '' ?>">
            <i class="bi bi-people"></i>
            <span>Manage Students</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Data</div>
        <a href="<?= $baseUrl ?>/import" class="nav-link <?= $current === 'import' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-arrow-up"></i>
            <span>Import Excel</span>
        </a>
        <a href="<?= $baseUrl ?>/export" class="nav-link <?= $current === 'export' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-arrow-down"></i>
            <span>Generate Report</span>
        </a>
        <a href="<?= $baseUrl ?>/docx-templates" class="nav-link <?= $current === 'docx_templates' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-word"></i>
            <span>Thesis Certification</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Administration</div>
        <a href="<?= $baseUrl ?>/users" class="nav-link <?= $current === 'users' ? 'active' : '' ?>">
            <i class="bi bi-shield-lock"></i>
            <span>Manage Users</span>
        </a>
        <a href="<?= $baseUrl ?>/staff" class="nav-link <?= $current === 'staff' ? 'active' : '' ?>">
            <i class="bi bi-person-video3"></i>
            <span>Academic Staff</span>
        </a>
    </div>

    <?php else: ?>
    <!-- ── User Navigation ── -->
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="<?= $baseUrl ?>/search" class="nav-link <?= $current === 'search' ? 'active' : '' ?>">
            <i class="bi bi-search"></i>
            <span>Search Students</span>
        </a>
        <a href="<?= $baseUrl ?>/export" class="nav-link <?= $current === 'export' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-arrow-down"></i>
            <span>Generate Report</span>
        </a>
        <a href="<?= $baseUrl ?>/docx-templates" class="nav-link <?= $current === 'docx_templates' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-word"></i>
            <span>Docx Templates</span>
        </a>
    </div>
    <?php endif; ?>

    <!-- ── Common ── -->
    <div class="nav-section">
        <div class="nav-section-title">Account</div>
        <a href="<?= $baseUrl ?>/profile" class="nav-link <?= $current === 'profile' ? 'active' : '' ?>">
            <i class="bi bi-person-circle"></i>
            <span>My Profile</span>
        </a>
        <a href="<?= $baseUrl ?>/logout" class="nav-link">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>

</aside>

<main class="prvts-main">

<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<?php if ($flash): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: var(--header-height);">
    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show animate-fade-in-up" role="alert">
        <?= strip_tags($flash['message'], '<strong><em><b><i><br><span>') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>
