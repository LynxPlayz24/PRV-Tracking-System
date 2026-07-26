<?php
namespace App\Models;

use App\Core\Database;

class Remark
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all remarks for a specific student
     */
    public function getForStudent(int $studentId): array
    {
        $this->db->query("
            SELECT * FROM student_remarks 
            WHERE student_id = :student_id 
            ORDER BY created_at DESC
        ");
        $this->db->bind(':student_id', $studentId);
        return $this->db->resultSet();
    }

    /**
     * Get single remark by ID
     */
    public function getById(int $remarkId): array|false
    {
        $this->db->query("SELECT * FROM student_remarks WHERE remark_id = :id");
        $this->db->bind(':id', $remarkId);
        return $this->db->single();
    }

    /**
     * Create a new student remark
     */
    public function create(array $data): int
    {
        $this->db->query("
            INSERT INTO student_remarks 
            (student_id, author_name, remark_text, file_path, file_name, file_type, file_size) 
            VALUES 
            (:student_id, :author_name, :remark_text, :file_path, :file_name, :file_type, :file_size)
        ");
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':author_name', $data['author_name']);
        $this->db->bind(':remark_text', $data['remark_text']);
        $this->db->bind(':file_path', $data['file_path'] ?? null);
        $this->db->bind(':file_name', $data['file_name'] ?? null);
        $this->db->bind(':file_type', $data['file_type'] ?? null);
        $this->db->bind(':file_size', $data['file_size'] ?? null);

        $this->db->execute();
        return (int)$this->db->lastInsertId();
    }

    /**
     * Delete a remark by ID
     */
    public function delete(int $remarkId): bool
    {
        $this->db->query("DELETE FROM student_remarks WHERE remark_id = :id");
        $this->db->bind(':id', $remarkId);
        return $this->db->execute();
    }
}
