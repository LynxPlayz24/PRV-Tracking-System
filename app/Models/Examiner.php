<?php
namespace App\Models;

use App\Core\Database;

class Examiner
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $this->db->query('SELECT * FROM examiners ORDER BY examiner_name ASC');
        return $this->db->resultSet();
    }

    public function getById(int $id): array|false
    {
        $this->db->query('SELECT * FROM examiners WHERE examiner_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function findByName(string $name): array|false
    {
        $this->db->query('SELECT * FROM examiners WHERE examiner_name = :name LIMIT 1');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }

    public function create(array $data): int
    {
        $this->db->query('INSERT INTO examiners (examiner_name, institution, email, phone) 
                          VALUES (:name, :institution, :email, :phone)');
        $this->db->bind(':name', $data['examiner_name']);
        $this->db->bind(':institution', empty($data['institution']) ? null : $data['institution']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query('UPDATE examiners SET 
                          examiner_name = :name, 
                          institution = :institution, 
                          email = :email 
                          WHERE examiner_id = :id');
        $this->db->bind(':name', $data['examiner_name']);
        $this->db->bind(':institution', empty($data['institution']) ? null : $data['institution']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM examiners WHERE examiner_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
