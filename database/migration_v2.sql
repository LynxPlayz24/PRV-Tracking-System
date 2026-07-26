-- ============================================================
-- PRVTS Migration v2
-- Added: student_remarks, supervisor phone, examiner classification, alert_resolutions
-- ============================================================

USE `prvts_db`;

-- 1. Create student_remarks table
CREATE TABLE IF NOT EXISTS `student_remarks` (
    `remark_id`       INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`      INT NOT NULL,
    `author_name`     VARCHAR(150) NOT NULL,
    `remark_text`     TEXT NOT NULL,
    `file_path`       VARCHAR(255) DEFAULT NULL,
    `file_name`       VARCHAR(255) DEFAULT NULL,
    `file_type`       VARCHAR(100) DEFAULT NULL,
    `file_size`       INT DEFAULT NULL,
    `created_at`      DATETIME DEFAULT CURRENT_TIMESTAMP,

    INDEX `idx_remarks_student` (`student_id`),
    CONSTRAINT `fk_remarks_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Add phone to supervisors table if not exists
SET @dbname = DATABASE();
SET @tablename = "supervisors";
SET @columnname = "phone";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 1",
  "ALTER TABLE supervisors ADD COLUMN phone VARCHAR(50) DEFAULT NULL AFTER email;"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 3. Add classification to examiners table if not exists
SET @tablename = "examiners";
SET @columnname = "classification";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 1",
  "ALTER TABLE examiners ADD COLUMN classification ENUM('Internal', 'External') NOT NULL DEFAULT 'Internal';"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 4. Create alert_resolutions table
CREATE TABLE IF NOT EXISTS `alert_resolutions` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `alert_key`    VARCHAR(100) NOT NULL UNIQUE,
    `resolved_by`  VARCHAR(150) DEFAULT NULL,
    `resolved_at`  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
