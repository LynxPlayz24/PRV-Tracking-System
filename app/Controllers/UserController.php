<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\User;

class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Render the user management page.
     */
    public function manage(): void
    {
        Middleware::requireAdmin();

        $this->generateCsrfToken();

        $data = [
            'pageTitle'   => 'Manage Users',
            'currentPage' => 'users',
            'users'       => $this->userModel->getAll()
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('users.manage', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * Create a new user account (admin action).
     */
    public function store(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        $name     = trim($this->input('name', ''));
        $email    = trim($this->input('email', ''));
        $username = trim($this->input('username', ''));
        $password = $this->input('password', '');
        $role     = $this->input('role', 'staff');

        // Validation
        $errors = [];
        if (empty($name))     $errors[] = 'Full name is required.';
        if (empty($email))    $errors[] = 'Email is required.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
        if (empty($username)) $errors[] = 'Username is required.';
        if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
        if (!in_array($role, ['admin', 'staff'])) $errors[] = 'Invalid role.';

        // Check uniqueness
        if ($this->userModel->usernameExists($username)) {
            $errors[] = 'Username is already taken.';
        }
        if ($this->userModel->emailExists($email)) {
            $errors[] = 'Email is already registered.';
        }

        if (!empty($errors)) {
            $this->setFlash('danger', implode('<br>', $errors));
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        if ($this->userModel->create([
            'name'     => $name,
            'email'    => $email,
            'username' => $username,
            'password' => $password,
            'role'     => $role,
        ])) {
            $this->setFlash('success', 'User <strong>' . htmlspecialchars($name) . '</strong> created successfully.');
        } else {
            $this->setFlash('danger', 'Failed to create user.');
        }

        $this->redirect($this->baseUrl() . '/users');
    }

    /**
     * Update the role of a specific user.
     */
    public function updateRole(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        $userId = (int)$id;
        $role = $this->input('role');

        if (!in_array($role, ['admin', 'staff'])) {
            $this->setFlash('danger', 'Invalid role.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        // Prevent self-demotion.
        if ($userId === $_SESSION['user_id'] && $role !== 'admin') {
            $this->setFlash('danger', 'You cannot change your own admin role.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        if ($this->userModel->updateRole($userId, $role)) {
            $this->setFlash('success', 'User role updated successfully.');
        } else {
            $this->setFlash('danger', 'Failed to update user role.');
        }

        $this->redirect($this->baseUrl() . '/users');
    }

    /**
     * Reset a user's password (admin action).
     */
    public function resetPassword(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        $userId = (int)$id;

        // Prevent resetting your own password here (use profile page instead).
        if ($userId === $_SESSION['user_id']) {
            $this->setFlash('danger', 'Use the Profile page to change your own password.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        $user = $this->userModel->findById($userId);
        if (!$user) {
            $this->setFlash('danger', 'User not found.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        $newPassword = trim($this->input('new_password', ''));

        if (strlen($newPassword) < 6) {
            $this->setFlash('danger', 'Password must be at least 6 characters.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        if ($this->userModel->updatePassword($userId, $newPassword)) {
            $this->userModel->setForcePasswordChange($userId);
            $this->setFlash('success', 'Password for <strong>' . htmlspecialchars($user['name']) . '</strong> has been reset successfully.');
        } else {
            $this->setFlash('danger', 'Failed to reset password.');
        }

        $this->redirect($this->baseUrl() . '/users');
    }

    /**
     * Delete a user.
     */
    public function delete(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        $userId = (int)$id;

        // Prevent self-deletion.
        if ($userId === $_SESSION['user_id']) {
            $this->setFlash('danger', 'You cannot delete yourself.');
            $this->redirect($this->baseUrl() . '/users');
            return;
        }

        // H2: Use the User model's delete() method instead of inlining raw SQL.
        if ($this->userModel->delete($userId)) {
            $this->setFlash('success', 'User deleted successfully.');
        } else {
            $this->setFlash('danger', 'Failed to delete user.');
        }

        $this->redirect($this->baseUrl() . '/users');
    }
}
