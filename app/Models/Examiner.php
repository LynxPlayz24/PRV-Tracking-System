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
        $this->db->query('SELECT * FROM examiners');
        $rows = $this->db->resultSet();
        return \App\Helpers\NameHelper::sortByName($rows, 'examiner_name');
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
        $this->db->query('INSERT INTO examiners (examiner_name, institution, email, phone, classification) 
                          VALUES (:name, :institution, :email, :phone, :classification)');
        $this->db->bind(':name', $data['examiner_name']);
        $this->db->bind(':institution', empty($data['institution']) ? null : $data['institution']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->bind(':classification', in_array($data['classification'] ?? '', ['Internal', 'External']) ? $data['classification'] : 'Internal');
        $this->db->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query('UPDATE examiners SET 
                          examiner_name = :name, 
                          institution = :institution, 
                          email = :email, 
                          phone = :phone, 
                          classification = :classification 
                          WHERE examiner_id = :id');
        $this->db->bind(':name', $data['examiner_name']);
        $this->db->bind(':institution', empty($data['institution']) ? null : $data['institution']);
        $this->db->bind(':email', empty($data['email']) ? null : $data['email']);
        $this->db->bind(':phone', empty($data['phone']) ? null : $data['phone']);
        $this->db->bind(':classification', in_array($data['classification'] ?? '', ['Internal', 'External']) ? $data['classification'] : 'Internal');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM examiners WHERE examiner_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function assignToStudent(int $studentId, int $examinerId, string $role, ?string $emailDate = null, string $status = 'Pending', ?string $reportDate = null): bool
    {
        $this->db->query('INSERT INTO student_examiners (student_id, examiner_id, role, email_date, status, report_date) 
                          VALUES (:student_id, :examiner_id, :role, :email_date, :status, :report_date)
                          ON DUPLICATE KEY UPDATE 
                          role = :role_upd, email_date = :email_date_upd, status = :status_upd, report_date = :report_date_upd');
        
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':examiner_id', $examinerId);
        $this->db->bind(':role', $role);
        $this->db->bind(':email_date', empty($emailDate) ? null : $emailDate);
        $this->db->bind(':status', $status);
        $this->db->bind(':report_date', empty($reportDate) ? null : $reportDate);
        
        $this->db->bind(':role_upd', $role);
        $this->db->bind(':email_date_upd', empty($emailDate) ? null : $emailDate);
        $this->db->bind(':status_upd', $status);
        $this->db->bind(':report_date_upd', empty($reportDate) ? null : $reportDate);

        return $this->db->execute();
    }

    public function getForStudent(int $studentId): array
    {
        $this->db->query('SELECT e.*, se.role, se.email_date, se.status, se.report_date 
                          FROM examiners e 
                          JOIN student_examiners se ON e.examiner_id = se.examiner_id 
                          WHERE se.student_id = :student_id ORDER BY se.role ASC, e.examiner_name ASC');
        $this->db->bind(':student_id', $studentId);
        return $this->db->resultSet();
    }

    public function removeAllFromStudent(int $studentId): bool
    {
        $this->db->query('DELETE FROM student_examiners WHERE student_id = :student_id');
        $this->db->bind(':student_id', $studentId);
        return $this->db->execute();
    }
}
