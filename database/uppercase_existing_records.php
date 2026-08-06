<?php
/**
 * Migration: Uppercase all existing supervisor names, examiner names, thesis titles, and chairpersons in database.
 * Run once: php database/uppercase_existing_records.php
 */

require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance();

$queries = [
    "UPDATE `supervisors` SET `supervisor_name` = UPPER(TRIM(`supervisor_name`)) WHERE `supervisor_name` IS NOT NULL AND `supervisor_name` != ''",
    "UPDATE `examiners` SET `examiner_name` = UPPER(TRIM(`examiner_name`)) WHERE `examiner_name` IS NOT NULL AND `examiner_name` != ''",
    "UPDATE `students` SET `thesis_title` = UPPER(TRIM(`thesis_title`)) WHERE `thesis_title` IS NOT NULL AND `thesis_title` != ''",
    "UPDATE `viva_records` SET `chairperson_name` = UPPER(TRIM(`chairperson_name`)) WHERE `chairperson_name` IS NOT NULL AND `chairperson_name` != ''",
    "UPDATE `viva_records` SET `reviva_chairperson_name` = UPPER(TRIM(`reviva_chairperson_name`)) WHERE `reviva_chairperson_name` IS NOT NULL AND `reviva_chairperson_name` != ''"
];

echo "Updating database records to UPPERCASE...\n";

foreach ($queries as $sql) {
    try {
        $db->query($sql);
        $db->execute();
        echo "OK: Executed query successfully.\n";
    } catch (\PDOException $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}

echo "Done.\n";
