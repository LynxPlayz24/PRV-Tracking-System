<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Core\Database;

$db = Database::getInstance();

$db->query("SELECT student_id FROM students");
$students = $db->resultSet();

$updated = 0;

foreach ($students as $s) {
    $studentId = (int)$s['student_id'];

    // Fetch related records
    $db->query("SELECT graduation_date, senate_meeting_date FROM graduation WHERE student_id = :id LIMIT 1");
    $db->bind(':id', $studentId);
    $grad = $db->single() ?: [];

    $db->query("SELECT final_result, corrected_thesis_received_date, endorsement_from_examiner_date FROM corrections WHERE student_id = :id LIMIT 1");
    $db->bind(':id', $studentId);
    $corr = $db->single() ?: [];

    $db->query("SELECT viva_date, viva_result FROM viva_records WHERE student_id = :id LIMIT 1");
    $db->bind(':id', $studentId);
    $viva = $db->single() ?: [];

    $db->query("SELECT COUNT(*) as cnt FROM student_examiners WHERE student_id = :id");
    $db->bind(':id', $studentId);
    $exCount = (int)($db->single()['cnt'] ?? 0);

    $gradDate       = trim($grad['graduation_date'] ?? '');
    $senateDate     = trim($grad['senate_meeting_date'] ?? '');
    $finalResult    = trim($corr['final_result'] ?? '');
    $corrReceived   = trim($corr['corrected_thesis_received_date'] ?? '');
    $endorsement    = trim($corr['endorsement_from_examiner_date'] ?? '');
    $vivaDate       = trim($viva['viva_date'] ?? '');
    $vivaResult     = trim($viva['viva_result'] ?? '');

    $newStatus = 'Thesis Submitted';

    if (!empty($gradDate) && $gradDate !== '0000-00-00') {
        $newStatus = 'Graduated';
    } elseif ((!empty($senateDate) && $senateDate !== '0000-00-00') || !empty($finalResult)) {
        $newStatus = 'Ready for Senate';
    } elseif ((!empty($corrReceived) && $corrReceived !== '0000-00-00') || (!empty($endorsement) && $endorsement !== '0000-00-00')) {
        $newStatus = 'Corrections Submitted';
    } elseif ((!empty($vivaDate) && $vivaDate !== '0000-00-00' && strtotime($vivaDate) <= time()) || !empty($vivaResult)) {
        $newStatus = 'Viva Completed';
    } elseif (!empty($vivaDate) && $vivaDate !== '0000-00-00') {
        $newStatus = 'Viva Scheduled';
    } elseif ($exCount > 0) {
        $newStatus = 'Examiner Assigned';
    }

    $db->query("UPDATE students SET research_status = :status WHERE student_id = :id");
    $db->bind(':status', $newStatus);
    $db->bind(':id', $studentId);
    $db->execute();
    $updated++;
}

echo "Successfully synced research status for $updated students." . PHP_EOL;
