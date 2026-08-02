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

        // Return actual rows affected by DB, not the input count.
        return $this->db->rowCount();
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

        // Retrieve examiners.
        $this->db->query('SELECT e.*, se.role, se.email_date, se.status, se.report_date 
                          FROM examiners e 
                          JOIN student_examiners se ON e.examiner_id = se.examiner_id 
                          WHERE se.student_id = :id ORDER BY se.role ASC, e.examiner_name ASC');
        $this->db->bind(':id', $studentId);
        $student['examiners'] = $this->db->resultSet();

        // Retrieve viva records.
        $this->db->query('SELECT * FROM viva_records WHERE student_id = :id ORDER BY viva_date DESC');
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
            if (is_array($filters['month'])) {
                $inClause = implode(',', array_fill(0, count($filters['month']), '?'));
                $sql .= " AND MONTH(viva_date) IN ($inClause) ";
                $params = array_merge($params, array_map('intval', array_values($filters['month'])));
            } else {
                $sql .= " AND MONTH(viva_date) = ? ";
                $params[] = (int)$filters['month'];
            }
        }

        if (!empty($filters['year'])) {
            if (is_array($filters['year'])) {
                $inClause = implode(',', array_fill(0, count($filters['year']), '?'));
                $sql .= " AND YEAR(viva_date) IN ($inClause) ";
                $params = array_merge($params, array_map('intval', array_values($filters['year'])));
            } else {
                $sql .= " AND YEAR(viva_date) = ? ";
                $params[] = (int)$filters['year'];
            }
        }

        if (!empty($filters['school'])) {
            if (is_array($filters['school'])) {
                $inClause = implode(',', array_fill(0, count($filters['school']), '?'));
                $sql .= " AND school IN ($inClause) ";
                $params = array_merge($params, array_values($filters['school']));
            } else {
                $sql .= " AND school = ? ";
                $params[] = $filters['school'];
            }
        }

        if (!empty($filters['programme'])) {
            if (is_array($filters['programme'])) {
                $inClause = implode(',', array_fill(0, count($filters['programme']), '?'));
                $sql .= " AND programme IN ($inClause) ";
                $params = array_merge($params, array_values($filters['programme']));
            } else {
                $sql .= " AND programme = ? ";
                $params[] = $filters['programme'];
            }
        }

        if (!empty($filters['degree_level'])) {
            if (is_array($filters['degree_level'])) {
                $inClause = implode(',', array_fill(0, count($filters['degree_level']), '?'));
                $sql .= " AND degree_level IN ($inClause) ";
                $params = array_merge($params, array_values($filters['degree_level']));
            } else {
                $sql .= " AND degree_level = ? ";
                $params[] = $filters['degree_level'];
            }
        }

        if (!empty($filters['research_status'])) {
            if (is_array($filters['research_status'])) {
                $inClause = implode(',', array_fill(0, count($filters['research_status']), '?'));
                $sql .= " AND research_status IN ($inClause) ";
                $params = array_merge($params, array_values($filters['research_status']));
            } else {
                $sql .= " AND research_status = ? ";
                $params[] = $filters['research_status'];
            }
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

        // Safety cap: prevent OOM on large bulk exports (500 records max per query).
        $sql .= " LIMIT 500";

        $this->db->query($sql);
        return $this->db->resultSet($params);
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

    /**
     * Get list of unique programmes
     */
    public function getProgrammes(): array
    {
        $this->db->query("SELECT DISTINCT programme FROM students WHERE programme IS NOT NULL AND programme != '' ORDER BY programme ASC");
        return array_column($this->db->resultSet(), 'programme');
    }
}
