-- ============================================================
-- PRVTS - Seed Data
-- ============================================================

USE `prvts_db`;

-- ============================================================
-- USERS (password is 'password123' hashed with bcrypt)
-- ============================================================
INSERT INTO `users` (`name`, `email`, `username`, `password`, `role`) VALUES
('Admin PRVTS', 'admin@uum.edu.my', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
