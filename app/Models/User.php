<?php
namespace App\Models;

use App\Core\Database;

/**
 * User Model
 * Handles all database operations for the users table.
 */
class User
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find user by username
     */
    public function findByUsername(string $username): array|false
    {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): array|false
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    /**
     * Find user by ID
     */
    public function findById(int $id): array|false
    {
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Create new user
     */
    public function create(array $data): bool
    {
        $this->db->query(
            'INSERT INTO users (name, email, username, password, role, force_password_change) 
             VALUES (:name, :email, :username, :password, :role, :force_pw)'
        );
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_BCRYPT));
        $this->db->bind(':role', $data['role'] ?? 'staff');
        $this->db->bind(':force_pw', $data['force_password_change'] ?? 1);
        return $this->db->execute();
    }

    /**
     * Update user profile
     */
    public function updateProfile(int $id, array $data): bool
    {
        $this->db->query(
            'UPDATE users SET name = :name, email = :email, username = :username, updated_at = NOW()
             WHERE user_id = :id'
        );
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Update password
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $this->db->query('UPDATE users SET password = :password, updated_at = NOW() WHERE user_id = :id');
        $this->db->bind(':password', password_hash($newPassword, PASSWORD_BCRYPT));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Set force_password_change flag
     */
    public function setForcePasswordChange(int $id, bool $force = true): bool
    {
        $this->db->query('UPDATE users SET force_password_change = :flag WHERE user_id = :id');
        $this->db->bind(':flag', $force ? 1 : 0);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Clear force_password_change flag
     */
    public function clearForcePasswordChange(int $id): bool
    {
        return $this->setForcePasswordChange($id, false);
    }

    /**
     * Update user role
     */
    public function updateRole(int $id, string $role): bool
    {
        $this->db->query('UPDATE users SET role = :role, updated_at = NOW() WHERE user_id = :id');
        $this->db->bind(':role', $role);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Delete user
     */
    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Get all users
     */
    public function getAll(): array
    {
        $this->db->query('SELECT user_id, name, email, username, role, created_at FROM users ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    /**
     * Check if username exists (excluding a specific user)
     */
    public function usernameExists(string $username, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $this->db->query('SELECT COUNT(*) as cnt FROM users WHERE username = :username AND user_id != :id');
            $this->db->bind(':id', $excludeId);
        } else {
            $this->db->query('SELECT COUNT(*) as cnt FROM users WHERE username = :username');
        }
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        return ($row['cnt'] ?? 0) > 0;
    }

    /**
     * Check if email exists (excluding a specific user)
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $this->db->query('SELECT COUNT(*) as cnt FROM users WHERE email = :email AND user_id != :id');
            $this->db->bind(':id', $excludeId);
        } else {
            $this->db->query('SELECT COUNT(*) as cnt FROM users WHERE email = :email');
        }
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return ($row['cnt'] ?? 0) > 0;
    }
}
