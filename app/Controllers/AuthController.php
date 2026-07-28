<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

/**
 * AuthController handles authentication, including login, registration, password resets, and logout.
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function login(): void
    {
        // Redirect to dashboard if already authenticated.
        if (isset($_SESSION['user_id'])) {
            $this->redirect($this->baseUrl() . '/dashboard');
            return;
        }

        $data = [
            'csrf_token' => $this->generateCsrfToken(),
            'flash'      => $this->getFlash(),
        ];
        require dirname(__DIR__) . '/Views/auth/login.php';
    }

    /**
     * Process login
     */
    public function loginPost(): void
    {
        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid security token. Please try again.');
            $this->redirect($this->baseUrl() . '/login');
            return;
        }

        // M7: Session-based rate limiting — block after 5 failed attempts for 15 minutes.
        $attempts  = $_SESSION['login_attempts'] ?? 0;
        $lockUntil = $_SESSION['login_lock_until'] ?? 0;

        if ($lockUntil > time()) {
            $remaining = ceil(($lockUntil - time()) / 60);
            $this->setFlash('danger', "Too many failed login attempts. Please try again in {$remaining} minute(s).");
            $this->redirect($this->baseUrl() . '/login');
            return;
        }

        // Reset lockout state if the lockout window has passed.
        if ($lockUntil && $lockUntil <= time()) {
            $_SESSION['login_attempts']  = 0;
            $_SESSION['login_lock_until'] = 0;
            $attempts = 0;
        }

        $username = trim($this->input('username', ''));
        $password = $this->input('password', '');

        // Validation
        if (empty($username) || empty($password)) {
            $this->setFlash('danger', 'Please enter both username and password.');
            $this->redirect($this->baseUrl() . '/login');
            return;
        }

        // Find user
        $user = $this->userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            // M7: Increment attempt counter and enforce delay.
            $_SESSION['login_attempts'] = $attempts + 1;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['login_lock_until'] = time() + (15 * 60); // 15-minute lockout
                $this->setFlash('danger', 'Too many failed login attempts. Account locked for 15 minutes.');
            } else {
                sleep(1); // Slow brute-force on every failed attempt
                $remaining_attempts = 5 - $_SESSION['login_attempts'];
                $this->setFlash('danger', "Invalid username or password. {$remaining_attempts} attempt(s) remaining.");
            }
            $this->redirect($this->baseUrl() . '/login');
            return;
        }

        // Successful login — clear rate limit state.
        $_SESSION['login_attempts']   = 0;
        $_SESSION['login_lock_until'] = 0;

        // Prevent session fixation
        session_regenerate_id(true);

        // Set session
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['username']  = $user['username'];

        // Force password change on first login
        if (!empty($user['force_password_change'])) {
            $_SESSION['force_password_change'] = true;
            $this->setFlash('warning', 'You must change your password before continuing.');
            $this->redirect($this->baseUrl() . '/profile');
            return;
        }

        $this->setFlash('success', 'Welcome back, ' . $user['name'] . '!');

        // Redirect based on role
        if ($user['role'] === 'admin') {
            $this->redirect($this->baseUrl() . '/dashboard');
        } else {
            $this->redirect($this->baseUrl() . '/search');
        }
    }

    /**
     * Show forgot password page (directs users to contact admin)
     */
    public function forgotPassword(): void
    {
        require dirname(__DIR__) . '/Views/auth/forgot_password.php';
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        // Clear session
        $_SESSION = [];

        // Delete session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();

        // Redirect to login
        $baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
        header("Location: {$baseUrl}/login");
        exit;
    }
}
