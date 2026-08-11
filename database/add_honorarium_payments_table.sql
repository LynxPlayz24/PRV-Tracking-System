-- Migration: Add honorarium_payments table for per-examiner honorarium storage
-- Run this in phpMyAdmin or via MySQL CLI

CREATE TABLE IF NOT EXISTS `honorarium_payments` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`    INT NOT NULL,
    `role`          ENUM('Chairperson', 'Internal', 'External', 'Refreshment') NOT NULL,
    `staff_name`    VARCHAR(200) DEFAULT NULL,
    `examiner_id`   INT DEFAULT NULL,
    `amount`        DECIMAL(10,2) DEFAULT NULL,
    CONSTRAINT `fk_hp_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_hp_examiner`
        FOREIGN KEY (`examiner_id`) REFERENCES `examiners`(`examiner_id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
