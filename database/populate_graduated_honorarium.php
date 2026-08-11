<?php
/**
 * Migration Script: Populate Honorarium Payments for Graduated Students
 *
 * Rates applied:
 * - Chairperson: RM 200.00
 * - Internal Examiner: RM 600.00
 * - External Examiner: RM 800.00
 * - Refreshment: None
 * - Payment Date: Pre-filled with viva_date
 *
 * Usage:
 * Save as `database/populate_graduated_honorarium.php` and run via CLI:
 * php database/populate_graduated_honorarium.php
 */

require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance();

    // 1. Fetch all Graduated students with their viva details and examiner IDs
    $db->query("
        SELECT 
            s.student_id, 
            s.name AS student_name, 
            vr.viva_date, 
            vr.chairperson_name, 
            vr.internal_examiner_id, 
            vr.external_examiner_id
        FROM students s
        INNER JOIN viva_records vr ON s.student_id = vr.student_id
        WHERE s.research_status = 'Graduated'
    ");
    
    $students = $db->resultSet();

    if (empty($students)) {
        echo "No graduated students found.\n";
        exit;
    }

    // Helper to fetch examiner name
    $getExaminerName = function($examinerId) use ($db) {
        if (!$examinerId) return null;
        $db->query("SELECT examiner_name FROM examiners WHERE examiner_id = :id");
        $db->bind(':id', (int)$examinerId);
        $row = $db->single();
        return $row ? $row['examiner_name'] : null;
    };

    $totalInserted = 0;

    foreach ($students as $s) {
        $studentId = (int)$s['student_id'];
        $vivaDate  = !empty($s['viva_date']) ? $s['viva_date'] : null;

        // Clear existing honorarium_payments for this student to avoid duplicates
        $db->query("DELETE FROM honorarium_payments WHERE student_id = :sid");
        $db->bind(':sid', $studentId);
        $db->execute();

        // 1. Chairperson (RM 200.00)
        if (!empty($s['chairperson_name'])) {
            $db->query("
                INSERT INTO honorarium_payments (student_id, role, staff_name, examiner_id, amount, payment_date)
                VALUES (:sid, 'Chairperson', :name, NULL, 200.00, :pdate)
            ");
            $db->bind(':sid', $studentId);
            $db->bind(':name', trim($s['chairperson_name']));
            $db->bind(':pdate', $vivaDate);
            $db->execute();
            $totalInserted++;
        }

        // 2. Internal Examiner (RM 600.00)
        if (!empty($s['internal_examiner_id'])) {
            $exId   = (int)$s['internal_examiner_id'];
            $exName = $getExaminerName($exId);

            $db->query("
                INSERT INTO honorarium_payments (student_id, role, staff_name, examiner_id, amount, payment_date)
                VALUES (:sid, 'Internal', :name, :ex_id, 600.00, :pdate)
            ");
            $db->bind(':sid', $studentId);
            $db->bind(':name', $exName);
            $db->bind(':ex_id', $exId);
            $db->bind(':pdate', $vivaDate);
            $db->execute();
            $totalInserted++;
        }

        // 3. External Examiner (RM 800.00)
        if (!empty($s['external_examiner_id'])) {
            $exId   = (int)$s['external_examiner_id'];
            $exName = $getExaminerName($exId);

            $db->query("
                INSERT INTO honorarium_payments (student_id, role, staff_name, examiner_id, amount, payment_date)
                VALUES (:sid, 'External', :name, :ex_id, 800.00, :pdate)
            ");
            $db->bind(':sid', $studentId);
            $db->bind(':name', $exName);
            $db->bind(':ex_id', $exId);
            $db->bind(':pdate', $vivaDate);
            $db->execute();
            $totalInserted++;
        }
    }

    echo "Successfully populated {$totalInserted} honorarium payment records across " . count($students) . " graduated students.\n";

} catch (\Exception $e) {
    echo "Error executing script: " . $e->getMessage() . "\n";
}
