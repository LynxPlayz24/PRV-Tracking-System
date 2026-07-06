<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\User;

class ProfileController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): void
    {
        Middleware::requireLogin();

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        $data = [
            'pageTitle'   => 'My Profile',
            'currentPage' => 'profile',
            'user'        => $user
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('profile.index', $data);
        $this->view('layouts.footer', $data);
    }

    public function update(): void
    {
        Middleware::requireLogin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/profile');
            return;
        }

        $userId = $_SESSION['user_id'];
        $name = trim($this->input('name'));
        $email = trim($this->input('email'));
        
        $password = $this->input('password');
        $confirmPassword = $this->input('confirm_password');

        if (empty($name) || empty($email)) {
            $this->setFlash('danger', 'Name and Email are required.');
            $this->redirect($this->baseUrl() . '/profile');
            return;
        }

        // Handle password update
        $hash = null;
        if (!empty($password)) {
            if ($password !== $confirmPassword) {
                $this->setFlash('danger', 'Passwords do not match.');
                $this->redirect($this->baseUrl() . '/profile');
                return;
            }
            if (strlen($password) < 6) {
                $this->setFlash('danger', 'Password must be at least 6 characters.');
                $this->redirect($this->baseUrl() . '/profile');
                return;
            }
            $hash = password_hash($password, PASSWORD_BCRYPT);
        }

        // Update DB via Database directly since User model might not have this specific method
        $db = \App\Core\Database::getInstance();
        
        $sql = 'UPDATE users SET name = :name, email = :email';
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':id' => $userId
        ];

        if ($hash) {
            $sql .= ', password_hash = :hash';
            $params[':hash'] = $hash;
        }

        $sql .= ' WHERE user_id = :id';

        $db->query($sql);
        foreach ($params as $param => $val) {
            $db->bind($param, $val);
        }

        if ($db->execute()) {
            $_SESSION['user_name'] = $name; // Update session name
            $this->setFlash('success', 'Profile updated successfully.');
        } else {
            $this->setFlash('danger', 'Failed to update profile.');
        }

        $this->redirect($this->baseUrl() . '/profile');
    }
}
