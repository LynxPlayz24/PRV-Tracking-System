<?php
namespace App\Models;

use App\Core\Database;

class Supervisor
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $this->db->query('SELECT * FROM supervisors ORDER BY supervisor_name ASC');
        return $this->db->resultSet();
    }

    public function assignToStudent(int $studentId, int $supervisorId, string $role = 'co'): bool
    {
        $this->db->query('INSERT INTO student_supervisors (student_id, supervisor_id, role) 
                          VALUES (:student_id, :supervisor_id, :role)
                          ON DUPLICATE KEY UPDATE role = :role2');
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':supervisor_id', $supervisorId);
        $this->db->bind(':role', $role);
        $this->db->bind(':role2', $role);
        return $this->db->execute();
    }

    public function removeAllFromStudent(int $studentId): bool
    {
        $this->db->query('DELETE FROM student_supervisors WHERE student_id = :id');
        $this->db->bind(':id', $studentId);
        return $this->db->execute();
    }

    public function getById(int $id): array|false
    {
        $this->db->query('SELECT * FROM supervisors WHERE supervisor_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function findByName(string $name): array|false
    {
        $this->db->query('SELECT * FROM supervisors WHERE supervisor_name = :name LIMIT 1');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }

    public function create(array $data): int
    {
        $this->db->query('INSERT INTO supervisors (supervisor_name, email, phone, department) 
                          VALUES (:name, :email, :phone, :dept)');
        $this->db->bind(':name', $data['supervisor_name']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->bind(':dept', empty($data['department']) ? null : $data['department']);
        $this->db->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query('UPDATE supervisors SET 
                          supervisor_name = :name, 
                          email = :email, 
                          phone = :phone, 
                          department = :dept 
                          WHERE supervisor_id = :id');
        $this->db->bind(':name', $data['supervisor_name']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->bind(':dept', empty($data['department']) ? null : $data['department']);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM supervisors WHERE supervisor_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
