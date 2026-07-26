<?php
namespace App\Models;

use App\Core\Database;

class Student
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findById(int $id): array|false
    {
        $this->db->query('SELECT * FROM students WHERE student_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function findByMatricNo(string $matricNo): array|false
    {
        $this->db->query('SELECT * FROM students WHERE matric_no = :matric_no');
        $this->db->bind(':matric_no', $matricNo);
        return $this->db->single();
    }

    public function create(array $data): int
    {
        $this->db->query('INSERT INTO students (matric_no, name, programme, school, degree_level, cohort, its_receipt_date, thesis_title, research_status) 
                          VALUES (:matric_no, :name, :programme, :school, :degree_level, :cohort, :its_receipt_date, :thesis_title, :research_status)');
        
        $this->db->bind(':matric_no', $data['matric_no']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':programme', $data['programme'] ?? null);
        $this->db->bind(':school', $data['school'] ?? null);
        $this->db->bind(':degree_level', $data['degree_level'] ?? 'Masters');
        $this->db->bind(':cohort', $data['cohort'] ?? null);
        $this->db->bind(':its_receipt_date', empty($data['its_receipt_date']) ? null : $data['its_receipt_date']);
        $this->db->bind(':thesis_title', $data['thesis_title'] ?? null);
        $this->db->bind(':research_status', $data['research_status'] ?? 'Thesis Submitted');
        
        $this->db->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query('UPDATE students SET matric_no = :matric_no, name = :name, programme = :programme, 
                          school = :school, degree_level = :degree_level, cohort = :cohort, its_receipt_date = :its_receipt_date, 
                          thesis_title = :thesis_title, research_status = :research_status WHERE student_id = :id');
        
        $this->db->bind(':matric_no', $data['matric_no']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':programme', $data['programme']);
        $this->db->bind(':school', $data['school']);
        $this->db->bind(':degree_level', $data['degree_level']);
        $this->db->bind(':cohort', $data['cohort'] ?? null);
        $this->db->bind(':its_receipt_date', empty($data['its_receipt_date']) ? null : $data['its_receipt_date']);
        $this->db->bind(':thesis_title', $data['thesis_title']);
        $this->db->bind(':research_status', $data['research_status']);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM students WHERE student_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteMultiple(array $ids): int
    {
        if (empty($ids)) return 0;

        // Build parameterized placeholders.
        $placeholders = [];
        foreach ($ids as $i => $id) {
            $placeholders[] = ':id' . $i;
        }
        $in = implode(',', $placeholders);

        $this->db->query("DELETE FROM students WHERE student_id IN ({$in})");
        foreach ($ids as $i => $id) {
            $this->db->bind(':id' . $i, (int)$id);
        }
        $this->db->execute();

        return count($ids);
    }

    public function getAll(): array
    {
        $this->db->query('SELECT * FROM students ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function getFullDetails(int $studentId): array|false
    {
        // Retrieve base student information.
        $student = $this->findById($studentId);
        if (!$student) return false;

        // Retrieve supervisors.
        $this->db->query('SELECT sup.*, ss.role FROM supervisors sup 
                          JOIN student_supervisors ss ON sup.supervisor_id = ss.supervisor_id 
                          WHERE ss.student_id = :id ORDER BY ss.role DESC');
        $this->db->bind(':id', $studentId);
        $student['supervisors'] = $this->db->resultSet();

        // Retrieve viva records and examiners.
        $this->db->query('SELECT v.*, 
                                 e_int.examiner_name as examiner_name, e_int.institution as institution, e_int.email as examiner_email,
                                 e_ext.examiner_name as external_examiner_name, e_ext.institution as external_institution, e_ext.email as external_email
                          FROM viva_records v 
                          LEFT JOIN examiners e_int ON v.internal_examiner_id = e_int.examiner_id 
                          LEFT JOIN examiners e_ext ON v.external_examiner_id = e_ext.examiner_id 
                          WHERE v.student_id = :id ORDER BY v.viva_date DESC');
        $this->db->bind(':id', $studentId);
        $student['viva_records'] = $this->db->resultSet();

        // Retrieve corrections.
        $this->db->query('SELECT * FROM corrections WHERE student_id = :id ORDER BY correction_id DESC LIMIT 1');
        $this->db->bind(':id', $studentId);
        $student['correction'] = $this->db->single() ?: null;

        // Retrieve graduation information.
        $this->db->query('SELECT * FROM graduation WHERE student_id = :id LIMIT 1');
        $this->db->bind(':id', $studentId);
        $student['graduation'] = $this->db->single() ?: null;

        return $student;
    }

    /**
     * Get filtered students with viva details for bulk export & sorting
     */
    public function getFiltered(array $filters = []): array
    {
        $sql = "SELECT * FROM (
                    SELECT s.*, 
                    (SELECT viva_date FROM viva_records WHERE student_id = s.student_id ORDER BY viva_date DESC LIMIT 1) as viva_date,
                    (SELECT viva_result FROM viva_records WHERE student_id = s.student_id ORDER BY viva_date DESC LIMIT 1) as viva_result
                    FROM students s
                ) as base
                WHERE 1=1 ";
        $params = [];

        if (!empty($filters['month'])) {
            $sql .= " AND MONTH(viva_date) = :month ";
            $params[':month'] = (int)$filters['month'];
        }

        if (!empty($filters['year'])) {
            $sql .= " AND YEAR(viva_date) = :year ";
            $params[':year'] = (int)$filters['year'];
        }

        if (!empty($filters['school'])) {
            $sql .= " AND school = :school ";
            $params[':school'] = $filters['school'];
        }

        if (!empty($filters['degree_level'])) {
            $sql .= " AND degree_level = :degree_level ";
            $params[':degree_level'] = $filters['degree_level'];
        }

        if (!empty($filters['research_status'])) {
            $sql .= " AND research_status = :research_status ";
            $params[':research_status'] = $filters['research_status'];
        }

        // Sorting
        $sortViva = $filters['sort_viva'] ?? '';
        if ($sortViva === 'asc') {
            $sql .= " ORDER BY (viva_date IS NULL) ASC, viva_date ASC, name ASC ";
        } elseif ($sortViva === 'desc') {
            $sql .= " ORDER BY (viva_date IS NULL) ASC, viva_date DESC, name ASC ";
        } elseif ($sortViva === 'month') {
            $sql .= " ORDER BY (viva_date IS NULL) ASC, MONTH(viva_date) ASC, DAY(viva_date) ASC, name ASC ";
        } else {
            $sql .= " ORDER BY name ASC ";
        }

        $this->db->query($sql);
        foreach ($params as $param => $val) {
            $this->db->bind($param, $val);
        }
        return $this->db->resultSet();
    }

    /**
     * Get list of unique schools
     */
    public function getSchools(): array
    {
        $this->db->query("SELECT DISTINCT school FROM students WHERE school IS NOT NULL AND school != '' ORDER BY school ASC");
        return array_column($this->db->resultSet(), 'school');
    }

    /**
     * Get list of unique viva years
     */
    public function getVivaYears(): array
    {
        $this->db->query("SELECT DISTINCT YEAR(viva_date) as yr FROM viva_records WHERE viva_date IS NOT NULL ORDER BY yr DESC");
        return array_column($this->db->resultSet(), 'yr');
    }
}
