<?php
namespace App\Models;

use App\Core\Database;

class HonorariumPayment
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Replace all honorarium rows for a student.
     * $payments = array of ['role', 'staff_name', 'examiner_id', 'amount', 'payment_date']
     */
    public function saveForStudent(int $studentId, array $payments): void
    {
        // Delete existing
        $this->db->query('DELETE FROM honorarium_payments WHERE student_id = :sid');
        $this->db->bind(':sid', $studentId);
        $this->db->execute();

        // Insert each row
        foreach ($payments as $p) {
            $amount = isset($p['amount']) && $p['amount'] !== '' ? (float)$p['amount'] : null;
            $paymentDate = !empty($p['payment_date']) ? $p['payment_date'] : null;

            if ($amount === null && $paymentDate === null) continue; // skip blank entries

            $this->db->query('INSERT INTO honorarium_payments (student_id, role, staff_name, examiner_id, amount, payment_date)
                              VALUES (:sid, :role, :staff_name, :examiner_id, :amount, :payment_date)');
            $this->db->bind(':sid', $studentId);
            $this->db->bind(':role', $p['role']);
            $this->db->bind(':staff_name', $p['staff_name'] ?? null);
            $this->db->bind(':examiner_id', isset($p['examiner_id']) && $p['examiner_id'] ? (int)$p['examiner_id'] : null);
            $this->db->bind(':amount', $amount);
            $this->db->bind(':payment_date', $paymentDate);
            $this->db->execute();
        }
    }

    /**
     * Get all honorarium rows for a student ordered by role.
     */
    public function getForStudent(int $studentId): array
    {
        $this->db->query('SELECT * FROM honorarium_payments WHERE student_id = :sid
                          ORDER BY FIELD(role, "Chairperson", "Internal", "External", "Refreshment"), id ASC');
        $this->db->bind(':sid', $studentId);
        return $this->db->resultSet();
    }

    /**
     * Sum of all amounts for a student.
     */
    public function getTotalForStudent(int $studentId): float
    {
        $this->db->query('SELECT SUM(amount) as total FROM honorarium_payments WHERE student_id = :sid');
        $this->db->bind(':sid', $studentId);
        return (float)($this->db->single()['total'] ?? 0);
    }
}
