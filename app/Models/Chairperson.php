<?php
namespace App\Models;

use App\Core\Database;

class Chairperson
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $this->db->query('SELECT * FROM chairpersons');
        $rows = $this->db->resultSet();
        return \App\Helpers\NameHelper::sortByName($rows, 'chairperson_name');
    }

    public function getById(int $id): array|false
    {
        $this->db->query('SELECT * FROM chairpersons WHERE chairperson_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create(array $data): int
    {
        $this->db->query('INSERT INTO chairpersons (chairperson_name, email, phone, department) 
                          VALUES (:name, :email, :phone, :dept)');
        $this->db->bind(':name', $data['chairperson_name']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->bind(':dept', empty($data['department']) ? null : $data['department']);
        $this->db->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query('UPDATE chairpersons SET 
                          chairperson_name = :name, 
                          email = :email, 
                          phone = :phone, 
                          department = :dept 
                          WHERE chairperson_id = :id');
        $this->db->bind(':name', $data['chairperson_name']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->bind(':dept', empty($data['department']) ? null : $data['department']);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM chairpersons WHERE chairperson_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
