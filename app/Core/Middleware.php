<?php
namespace App\Core;

/**
 * Middleware Class
 * Handles authentication guards and role-based access control.
 */
class Middleware
{
    /**
     * Require user to be logged in.
     * Redirects to login page if not authenticated.
     */
    public static function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = [
                'type'    => 'warning',
                'message' => 'Please log in to access this page.',
            ];
            $baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
            header("Location: {$baseUrl}/login");
            exit;
        }
    }

    /**
     * Require user to have admin role.
     * Redirects to search page with error if not admin.
     */
    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            $_SESSION['flash'] = [
                'type'    => 'danger',
                'message' => 'Access denied. Admin privileges required.',
            ];
            $baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
            header("Location: {$baseUrl}/search");
            exit;
        }
    }

    /**
     * Check if user is logged in (without redirect)
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if current user is admin
     */
    public static function isAdmin(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'admin';
    }

    /**
     * Get current user ID
     */
    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get current user name
     */
    public static function userName(): ?string
    {
        return $_SESSION['user_name'] ?? null;
    }

    /**
     * Get current user role
     */
    public static function userRole(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }
}
