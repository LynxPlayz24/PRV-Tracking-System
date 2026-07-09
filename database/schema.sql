-- ============================================================
-- PRVTS - Postgraduate Research & Viva Tracking System
-- Database Schema for MySQL 8+
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";

CREATE DATABASE IF NOT EXISTS `prvts_db`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `prvts_db`;

-- ============================================================
-- 1. USERS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
    `user_id`       INT AUTO_INCREMENT PRIMARY KEY,
    `name`          VARCHAR(150) NOT NULL,
    `email`         VARCHAR(200) NOT NULL UNIQUE,
    `username`      VARCHAR(100) NOT NULL UNIQUE,
    `password`      VARCHAR(255) NOT NULL,
    `role`          ENUM('admin','staff') NOT NULL DEFAULT 'staff',
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. STUDENTS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `students` (
    `student_id`      INT AUTO_INCREMENT PRIMARY KEY,
    `matric_no`       VARCHAR(30) NOT NULL UNIQUE,
    `name`            VARCHAR(200) NOT NULL,
    `programme`       VARCHAR(200) DEFAULT NULL,
    `school`          VARCHAR(200) DEFAULT NULL,
    `degree_level`    ENUM('Masters','PhD','DBA') NOT NULL DEFAULT 'Masters',
    `cohort`          VARCHAR(50) DEFAULT NULL,
    `its_receipt_date` DATE DEFAULT NULL,
    `thesis_title`    TEXT DEFAULT NULL,
    `research_status` ENUM(
        'Thesis Submitted',
        'Examiner Assigned',
        'Viva Scheduled',
        'Viva Completed',
        'Corrections Submitted',
        'Ready for Senate',
        'Graduated'
    ) NOT NULL DEFAULT 'Thesis Submitted',
    `created_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX `idx_students_name`     (`name`),
    INDEX `idx_students_school`   (`school`),
    INDEX `idx_students_status`   (`research_status`),
    INDEX `idx_students_degree`   (`degree_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. SUPERVISORS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `supervisors` (
    `supervisor_id`   INT AUTO_INCREMENT PRIMARY KEY,
    `supervisor_name` VARCHAR(200) NOT NULL,
    `email`           VARCHAR(200) DEFAULT NULL,
    `department`      VARCHAR(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. STUDENT_SUPERVISORS JUNCTION TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `student_supervisors` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`    INT NOT NULL,
    `supervisor_id` INT NOT NULL,
    `role`          ENUM('main','co') NOT NULL DEFAULT 'main',

    UNIQUE KEY `uk_student_supervisor` (`student_id`, `supervisor_id`),

    CONSTRAINT `fk_ss_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_ss_supervisor`
        FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors`(`supervisor_id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. EXAMINERS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `examiners` (
    `examiner_id`   INT AUTO_INCREMENT PRIMARY KEY,
    `examiner_name` VARCHAR(200) NOT NULL,
    `institution`   VARCHAR(200) DEFAULT NULL,
    `email`         VARCHAR(200) DEFAULT NULL,
    `phone`         VARCHAR(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. VIVA_RECORDS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `viva_records` (
    `viva_id`                   INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`                INT NOT NULL,
    `internal_examiner_id`      INT DEFAULT NULL,
    `external_examiner_id`      INT DEFAULT NULL,
    `chairperson_name`          VARCHAR(200) DEFAULT NULL,
    `thesis_submission_email_date` DATE DEFAULT NULL,
    `draft_hard_copy_date`      DATE DEFAULT NULL,
    `draft_soft_copy_date`      DATE DEFAULT NULL,
    `turnitin_percentage`       VARCHAR(10) DEFAULT NULL,
    `draft_submission_form_date` DATE DEFAULT NULL,
    `internal_examiner_email_date` DATE DEFAULT NULL,
    `external_examiner_email_date` DATE DEFAULT NULL,
    `panel_appointment_letter_date` DATE DEFAULT NULL,
    `thesis_to_panel_hard_copy_date` DATE DEFAULT NULL,
    `thesis_to_panel_soft_copy_date` DATE DEFAULT NULL,
    `confirm_date_email_date`   DATE DEFAULT NULL,
    `invitation_letter_date`    DATE DEFAULT NULL,
    `viva_date`                 DATE DEFAULT NULL,
    `viva_result`               VARCHAR(100) DEFAULT NULL,
    `internal_examiner_report_date` DATE DEFAULT NULL,
    `best_thesis_candidate`     TINYINT(1) DEFAULT 0,
    `honorarium_chairperson`    VARCHAR(100) DEFAULT NULL,
    `honorarium_internal`       VARCHAR(100) DEFAULT NULL,
    `honorarium_external`       VARCHAR(100) DEFAULT NULL,
    `honorarium_refreshment`    VARCHAR(100) DEFAULT NULL,

    INDEX `idx_viva_student` (`student_id`),
    INDEX `idx_viva_date`    (`viva_date`),

    CONSTRAINT `fk_viva_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_viva_internal_exam`
        FOREIGN KEY (`internal_examiner_id`) REFERENCES `examiners`(`examiner_id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_viva_external_exam`
        FOREIGN KEY (`external_examiner_id`) REFERENCES `examiners`(`examiner_id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. CORRECTIONS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `corrections` (
    `correction_id`            INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`               INT NOT NULL,
    `correction_required`      TINYINT(1) NOT NULL DEFAULT 0,
    `correction_deadline`      DATE DEFAULT NULL,
    `correction_submission_date` DATE DEFAULT NULL,
    `verification_status`      ENUM('Pending','In Progress','Verified','Rejected') DEFAULT 'Pending',
    `reviewed_by`              VARCHAR(100) DEFAULT NULL,
    `report_sent_to_student_date` DATE DEFAULT NULL,
    `internal_report_status`   VARCHAR(100) DEFAULT NULL,
    `external_report_status`   VARCHAR(100) DEFAULT NULL,
    `corrected_thesis_received_date` DATE DEFAULT NULL,
    `checklist_after_viva_date` DATE DEFAULT NULL,
    `correction_schedule_date` DATE DEFAULT NULL,
    `post_viva_turnitin_percentage` VARCHAR(10) DEFAULT NULL,
    `supervisor_endorsement_date` DATE DEFAULT NULL,
    `sent_to_internal_date`    DATE DEFAULT NULL,
    `sent_to_external_date`    DATE DEFAULT NULL,
    `sent_to_supervisor_date`  DATE DEFAULT NULL,
    `endorsement_from_examiner_date` DATE DEFAULT NULL,
    `abstract_received_date`   DATE DEFAULT NULL,
    `final_result`             VARCHAR(200) DEFAULT NULL,

    INDEX `idx_corr_student` (`student_id`),

    CONSTRAINT `fk_corr_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. GRADUATION TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS `graduation` (
    `graduation_id`     INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`        INT NOT NULL,
    `jil_status`        ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    `senate_status`     ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    `graduation_status` ENUM('Not Ready','Ready','Graduated') DEFAULT 'Not Ready',
    `graduation_date`   DATE DEFAULT NULL,
    `gais_keyin_date`   DATE DEFAULT NULL,
    `jil_meeting_date`  DATE DEFAULT NULL,
    `jil_meeting_no`    VARCHAR(100) DEFAULT NULL,
    `senate_meeting_date` DATE DEFAULT NULL,
    `senate_meeting_no` VARCHAR(100) DEFAULT NULL,
    `thesis_certification_date` DATE DEFAULT NULL,
    `final_thesis_form_date` DATE DEFAULT NULL,
    `hard_bound_copies_date` DATE DEFAULT NULL,
    `loose_copy_date`   DATE DEFAULT NULL,
    `cd_copies_date`    DATE DEFAULT NULL,
    `etd_form_date`     DATE DEFAULT NULL,
    `sent_to_psb_date`  DATE DEFAULT NULL,

    INDEX `idx_grad_student` (`student_id`),

    CONSTRAINT `fk_grad_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
