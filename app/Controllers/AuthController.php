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

        $username = trim($this->input('username', ''));
        $password = $this->input('password', '');
        $remember = $this->input('remember') ? true : false;

        // Validation
        if (empty($username) || empty($password)) {
            $this->setFlash('danger', 'Please enter both username and password.');
            $this->redirect($this->baseUrl() . '/login');
            return;
        }

        // Find user
        $user = $this->userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->setFlash('danger', 'Invalid username or password.');
            $this->redirect($this->baseUrl() . '/login');
            return;
        }

        // Prevent session fixation
        session_regenerate_id(true);

        // Set session
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['username']  = $user['username'];

        // Remember me cookie (30 days)
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
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
     * Show registration form
     */
    public function register(): void
    {
        $data = [
            'csrf_token' => $this->generateCsrfToken(),
            'flash'      => $this->getFlash(),
        ];
        require dirname(__DIR__) . '/Views/auth/register.php';
    }

    /**
     * Process registration
     */
    public function registerPost(): void
    {
        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid security token. Please try again.');
            $this->redirect($this->baseUrl() . '/register');
            return;
        }

        $name     = trim($this->input('name', ''));
        $email    = trim($this->input('email', ''));
        $username = trim($this->input('username', ''));
        $password = $this->input('password', '');
        $confirm  = $this->input('confirm_password', '');

        // Validation
        $errors = [];
        if (empty($name))     $errors[] = 'Full name is required.';
        if (empty($email))    $errors[] = 'Email is required.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
        if (empty($username)) $errors[] = 'Username is required.';
        if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
        if ($password !== $confirm) $errors[] = 'Passwords do not match.';

        // Check uniqueness
        if ($this->userModel->usernameExists($username)) {
            $errors[] = 'Username is already taken.';
        }
        if ($this->userModel->emailExists($email)) {
            $errors[] = 'Email is already registered.';
        }

        if (!empty($errors)) {
            $this->setFlash('danger', implode('<br>', $errors));
            $this->redirect($this->baseUrl() . '/register');
            return;
        }

        // Create user
        $this->userModel->create([
            'name'     => $name,
            'email'    => $email,
            'username' => $username,
            'password' => $password,
            'role'     => 'user',
        ]);

        $this->setFlash('success', 'Registration successful! Please log in.');
        $this->redirect($this->baseUrl() . '/login');
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

        // Delete remember me cookie
        setcookie('remember_token', '', time() - 42000, '/');

        session_destroy();

        // Redirect to login
        $baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
        header("Location: {$baseUrl}/login");
        exit;
    }
}
