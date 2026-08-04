<?php
/**
 * Migration: Add re-viva fields to viva_records table.
 * Run once: php database/add_reviva_fields.php
 */

require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance();

$alterStatements = [
    "ALTER TABLE `viva_records`
        ADD COLUMN `reviva_internal_examiner_id`             INT DEFAULT NULL            AFTER `honorarium_refreshment`,
        ADD COLUMN `reviva_external_examiner_id`             INT DEFAULT NULL            AFTER `reviva_internal_examiner_id`,
        ADD COLUMN `reviva_panel_appointment_letter_date`     DATE DEFAULT NULL           AFTER `reviva_external_examiner_id`,
        ADD COLUMN `reviva_thesis_to_panel_hard_copy_date`   DATE DEFAULT NULL           AFTER `reviva_panel_appointment_letter_date`,
        ADD COLUMN `reviva_thesis_to_panel_soft_copy_date`   DATE DEFAULT NULL           AFTER `reviva_thesis_to_panel_hard_copy_date`,
        ADD COLUMN `reviva_confirm_date_email_date`          DATE DEFAULT NULL           AFTER `reviva_thesis_to_panel_soft_copy_date`,
        ADD COLUMN `reviva_invitation_letter_date`           DATE DEFAULT NULL           AFTER `reviva_confirm_date_email_date`,
        ADD COLUMN `reviva_date`                             DATE DEFAULT NULL           AFTER `reviva_invitation_letter_date`,
        ADD COLUMN `reviva_chairperson_name`                 VARCHAR(200) DEFAULT NULL   AFTER `reviva_date`,
        ADD COLUMN `reviva_result`                           VARCHAR(100) DEFAULT NULL   AFTER `reviva_chairperson_name`,
        ADD CONSTRAINT `fk_viva_reviva_internal_exam`
            FOREIGN KEY (`reviva_internal_examiner_id`) REFERENCES `examiners`(`examiner_id`)
            ON DELETE SET NULL ON UPDATE CASCADE,
        ADD CONSTRAINT `fk_viva_reviva_external_exam`
            FOREIGN KEY (`reviva_external_examiner_id`) REFERENCES `examiners`(`examiner_id`)
            ON DELETE SET NULL ON UPDATE CASCADE"
];

foreach ($alterStatements as $sql) {
    try {
        $db->query($sql);
        $db->execute();
        echo "OK: Added re-viva columns to viva_records.\n";
    } catch (\PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false || strpos($e->getMessage(), 'already exists') !== false) {
            echo "SKIP: Columns already exist.\n";
        } else {
            echo "ERROR: " . $e->getMessage() . "\n";
        }
    }
}

echo "Done.\n";
