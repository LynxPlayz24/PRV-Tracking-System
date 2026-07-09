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

        // Execute delete directly via DB if UserModel lacks a delete method.
        $db = \App\Core\Database::getInstance();
        $db->query('DELETE FROM users WHERE user_id = :id');
        $db->bind(':id', $userId);
        
        if ($db->execute()) {
            $this->setFlash('success', 'User deleted successfully.');
        } else {
            $this->setFlash('danger', 'Failed to delete user.');
        }

        $this->redirect($this->baseUrl() . '/users');
    }
}
