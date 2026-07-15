<?php
namespace App\Core;

/**
 * Base Controller
 * Provides view rendering, redirects, JSON responses, and CSRF protection.
 */
class Controller
{
    /**
     * Render a view file with optional data
     */
    protected function view(string $viewPath, array $data = []): void
    {
        // Extract data to make variables available in view
        extract($data);

        $viewFile = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View file not found: {$viewFile}");
        }

        require $viewFile;
    }

    /**
     * Redirect to a URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Send a JSON response
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Generate a CSRF token and store in session
     */
    protected function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate the CSRF token from POST data
     */
    protected function validateCsrfToken(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            return false;
        }
        // Regenerate token after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return true;
    }

    /**
     * Get POST data with optional default
     */
    protected function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Get GET parameter with optional default
     */
    protected function param(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Set flash message in session
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    /**
     * Get and clear flash message
     */
    protected function getFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Get the application base URL
     */
    protected function baseUrl(): string
    {
        return rtrim($_ENV['APP_URL'] ?? '', '/');
    }
}
