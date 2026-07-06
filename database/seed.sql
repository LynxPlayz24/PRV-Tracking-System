-- ============================================================
-- PRVTS - Sample Seed Data
-- ============================================================

USE `prvts_db`;

-- ============================================================
-- USERS (password is 'password123' hashed with bcrypt)
-- ============================================================
INSERT INTO `users` (`name`, `email`, `username`, `password`, `role`) VALUES
('Admin PRVTS', 'admin@uum.edu.my', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Nur Aisyah binti Ahmad', 'aisyah@uum.edu.my', 'aisyah', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- ============================================================
-- SUPERVISORS
-- ============================================================
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES
('Prof. Dr. Ahmad bin Hassan', 'ahmad.hassan@uum.edu.my', 'School of Computing'),
('Assoc. Prof. Dr. Siti Aminah binti Yusof', 'siti.aminah@uum.edu.my', 'School of Business Management'),
('Dr. Muhammad Faisal bin Abdullah', 'faisal.abdullah@uum.edu.my', 'School of Computing'),
('Prof. Dr. Norazlina binti Mohd Yasin', 'norazlina@uum.edu.my', 'School of Economics, Finance & Banking'),
('Dr. Lim Wei Chen', 'lim.wc@uum.edu.my', 'School of Technology Management & Logistics'),
('Assoc. Prof. Dr. Faizah binti Othman', 'faizah.othman@uum.edu.my', 'School of Business Management'),
('Dr. Rajesh Kumar a/l Subramaniam', 'rajesh.kumar@uum.edu.my', 'School of Computing'),
('Prof. Dr. Wan Rozaini binti Sheik Osman', 'wan.rozaini@uum.edu.my', 'School of Computing');

-- ============================================================
-- EXAMINERS
-- ============================================================
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`) VALUES
('Prof. Dr. Zulkifli bin Mansor', 'Universiti Malaya', 'zulkifli@um.edu.my'),
('Assoc. Prof. Dr. Tan Siew Bee', 'Universiti Sains Malaysia', 'tan.sb@usm.my'),
('Prof. Dr. Haslinda binti Ibrahim', 'Universiti Teknologi Malaysia', 'haslinda@utm.my'),
('Dr. Kamal bin Ismail', 'Universiti Kebangsaan Malaysia', 'kamal@ukm.edu.my'),
('Prof. Dr. Anuar bin Shah', 'Universiti Putra Malaysia', 'anuar@upm.edu.my'),
('Assoc. Prof. Dr. Noor Azizah binti Mohamad', 'Universiti Teknologi MARA', 'noorazizah@uitm.edu.my');

-- ============================================================
-- STUDENTS (20 students across various schools and degree levels)
-- ============================================================
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `thesis_title`, `research_status`) VALUES
('901234', 'Amirul Hakim bin Razali', 'Master of Science (Information Technology)', 'School of Computing', 'Masters', 'A Framework for Cloud Computing Adoption in Malaysian SMEs', 'Graduated'),
('901235', 'Nurul Hidayah binti Kamarudin', 'Doctor of Philosophy (Management)', 'School of Business Management', 'PhD', 'Impact of Transformational Leadership on Employee Performance in GLCs', 'Ready for Senate'),
('901236', 'Lee Chong Wei', 'Master of Science (Finance)', 'School of Economics, Finance & Banking', 'Masters', 'Cryptocurrency Market Volatility and Investor Behaviour in Southeast Asia', 'Corrections Submitted'),
('901237', 'Priya a/p Krishnan', 'Doctor of Philosophy (Information Technology)', 'School of Computing', 'PhD', 'Deep Learning Approaches for Malay Sentiment Analysis in Social Media', 'Viva Completed'),
('901238', 'Muhammad Hafiz bin Zainal', 'Master of Science (Technology Management)', 'School of Technology Management & Logistics', 'Masters', 'Industry 4.0 Readiness Assessment for Malaysian Manufacturing Sector', 'Viva Scheduled'),
('901239', 'Siti Nurhaliza binti Mohd Ali', 'Doctor of Philosophy (Accounting)', 'School of Business Management', 'PhD', 'Corporate Governance and Earnings Management in Shariah-Compliant Companies', 'Examiner Assigned'),
('901240', 'Tan Mei Ling', 'Master of Science (Computer Science)', 'School of Computing', 'Masters', 'Blockchain-Based Supply Chain Traceability System for Halal Products', 'Thesis Submitted'),
('901241', 'Ahmad Danial bin Osman', 'Doctor of Business Administration', 'School of Business Management', 'DBA', 'Strategic Innovation and Competitive Advantage in Malaysian Banking Sector', 'Graduated'),
('901242', 'Fatimah Zahra binti Hassan', 'Doctor of Philosophy (Economics)', 'School of Economics, Finance & Banking', 'PhD', 'Fiscal Policy Effectiveness in ASEAN Developing Economies', 'Viva Completed'),
('901243', 'Raj Kumar a/l Muthu', 'Master of Science (Logistics)', 'School of Technology Management & Logistics', 'Masters', 'Last-Mile Delivery Optimization Using Machine Learning', 'Viva Scheduled'),
('901244', 'Nor Syafiqah binti Ismail', 'Master of Science (Information Technology)', 'School of Computing', 'Masters', 'Cybersecurity Awareness Framework for Malaysian Government Agencies', 'Graduated'),
('901245', 'Wong Jia Hao', 'Doctor of Philosophy (Computer Science)', 'School of Computing', 'PhD', 'Federated Learning for Privacy-Preserving Healthcare Data Analytics', 'Examiner Assigned'),
('901246', 'Aisyah Humaira binti Zainuddin', 'Master of Science (Human Resource Management)', 'School of Business Management', 'Masters', 'Work-Life Balance and Job Satisfaction Among Remote Workers in Malaysia', 'Corrections Submitted'),
('901247', 'Mohd Izzat bin Sulaiman', 'Doctor of Philosophy (Finance)', 'School of Economics, Finance & Banking', 'PhD', 'Islamic Fintech Adoption and Financial Inclusion in Rural Communities', 'Thesis Submitted'),
('901248', 'Kavitha a/p Raman', 'Master of Science (Decision Science)', 'School of Quantitative Sciences', 'Masters', 'Multi-Criteria Decision Making for Sustainable Tourism Development', 'Viva Completed'),
('901249', 'Zulkifli bin Ahmad Tajuddin', 'Doctor of Philosophy (Management)', 'School of Business Management', 'PhD', 'Knowledge Management Practices and Innovation in Malaysian Public Universities', 'Ready for Senate'),
('901250', 'Chen Li Ying', 'Master of Science (Data Analytics)', 'School of Computing', 'Masters', 'Predictive Analytics for Student Retention in Higher Education', 'Graduated'),
('901251', 'Nurul Ain binti Mohd Fauzi', 'Master of Science (Banking)', 'School of Economics, Finance & Banking', 'Masters', 'Digital Banking Adoption Barriers Among Elderly Population in Malaysia', 'Examiner Assigned'),
('901252', 'Arjun a/l Selvam', 'Doctor of Philosophy (Technology Management)', 'School of Technology Management & Logistics', 'PhD', 'Internet of Things Adoption Model for Smart Agriculture in Malaysia', 'Viva Scheduled'),
('901253', 'Siti Khadijah binti Abdullah', 'Doctor of Business Administration', 'School of Business Management', 'DBA', 'Succession Planning Effectiveness in Malaysian Family-Owned Businesses', 'Thesis Submitted');

-- ============================================================
-- STUDENT_SUPERVISORS
-- ============================================================
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES
(1, 1, 'main'), (1, 3, 'co'),
(2, 2, 'main'), (2, 6, 'co'),
(3, 4, 'main'),
(4, 1, 'main'), (4, 7, 'co'),
(5, 5, 'main'),
(6, 2, 'main'), (6, 6, 'co'),
(7, 3, 'main'),
(8, 2, 'main'), (8, 6, 'co'),
(9, 4, 'main'),
(10, 5, 'main'), (10, 7, 'co'),
(11, 1, 'main'), (11, 8, 'co'),
(12, 7, 'main'),
(13, 6, 'main'),
(14, 4, 'main'),
(15, 8, 'main'),
(16, 2, 'main'), (16, 6, 'co'),
(17, 3, 'main'), (17, 8, 'co'),
(18, 4, 'main'),
(19, 5, 'main'), (19, 7, 'co'),
(20, 2, 'main');

-- ============================================================
-- VIVA_RECORDS
-- ============================================================
INSERT INTO `viva_records` (`student_id`, `examiner_id`, `thesis_submission_date`, `examiner_appointment_date`, `examiner_acceptance_date`, `thesis_sent_date`, `viva_date`, `viva_result`) VALUES
(1, 1, '2025-01-15', '2025-02-01', '2025-02-10', '2025-02-15', '2025-04-10', 'Pass with Minor Corrections'),
(2, 2, '2025-03-01', '2025-03-20', '2025-04-01', '2025-04-05', '2025-06-01', 'Pass with Minor Corrections'),
(3, 3, '2025-02-10', '2025-02-28', '2025-03-10', '2025-03-15', '2025-05-15', 'Pass with Major Corrections'),
(4, 4, '2024-11-01', '2024-11-15', '2024-11-25', '2024-12-01', '2025-02-20', 'Pass with Minor Corrections'),
(5, 5, '2025-04-01', '2025-04-15', '2025-04-25', '2025-05-01', '2025-07-10', NULL),
(6, 6, '2025-05-01', '2025-05-20', NULL, NULL, NULL, NULL),
(7, NULL, '2025-06-01', NULL, NULL, NULL, NULL, NULL),
(8, 1, '2024-08-01', '2024-08-15', '2024-08-25', '2024-09-01', '2024-11-15', 'Pass'),
(9, 2, '2025-01-20', '2025-02-05', '2025-02-15', '2025-02-20', '2025-04-25', 'Pass with Minor Corrections'),
(10, 3, '2025-03-15', '2025-04-01', '2025-04-10', '2025-04-15', '2025-07-05', NULL),
(11, 4, '2024-10-01', '2024-10-15', '2024-10-25', '2024-11-01', '2025-01-10', 'Pass'),
(12, 5, '2025-04-10', '2025-04-25', NULL, NULL, NULL, NULL),
(13, 6, '2025-02-15', '2025-03-01', '2025-03-10', '2025-03-15', '2025-05-20', 'Pass with Minor Corrections'),
(14, NULL, '2025-06-10', NULL, NULL, NULL, NULL, NULL),
(15, 1, '2024-12-01', '2024-12-15', '2024-12-25', '2025-01-05', '2025-03-15', 'Pass'),
(16, 2, '2025-03-01', '2025-03-20', '2025-04-01', '2025-04-05', '2025-06-01', 'Pass with Minor Corrections'),
(17, 3, '2024-09-01', '2024-09-15', '2024-09-25', '2024-10-01', '2024-12-10', 'Pass'),
(18, 4, '2025-05-15', '2025-06-01', NULL, NULL, NULL, NULL),
(19, 5, '2025-04-20', '2025-05-05', '2025-05-15', '2025-05-20', '2025-07-20', NULL),
(20, NULL, '2025-06-15', NULL, NULL, NULL, NULL, NULL);

-- ============================================================
-- CORRECTIONS
-- ============================================================
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, `verification_status`) VALUES
(1, 1, '2025-07-10', '2025-06-15', 'Verified'),
(2, 1, '2025-09-01', '2025-08-10', 'Verified'),
(3, 1, '2025-08-15', '2025-08-01', 'In Progress'),
(4, 1, '2025-05-20', '2025-04-30', 'Verified'),
(8, 0, NULL, NULL, 'Verified'),
(9, 1, '2025-07-25', '2025-07-10', 'Verified'),
(11, 0, NULL, NULL, 'Verified'),
(13, 1, '2025-08-20', '2025-08-05', 'In Progress'),
(15, 0, NULL, NULL, 'Verified'),
(16, 1, '2025-09-01', NULL, 'Pending'),
(17, 0, NULL, NULL, 'Verified');

-- ============================================================
-- GRADUATION
-- ============================================================
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`) VALUES
(1, 'Approved', 'Approved', 'Graduated', '2025-10-15'),
(2, 'Approved', 'Pending', 'Ready', NULL),
(3, 'Pending', 'Pending', 'Not Ready', NULL),
(4, 'Approved', 'Pending', 'Not Ready', NULL),
(8, 'Approved', 'Approved', 'Graduated', '2025-03-20'),
(9, 'Pending', 'Pending', 'Not Ready', NULL),
(11, 'Approved', 'Approved', 'Graduated', '2025-05-15'),
(13, 'Pending', 'Pending', 'Not Ready', NULL),
(15, 'Pending', 'Pending', 'Not Ready', NULL),
(16, 'Approved', 'Pending', 'Ready', NULL),
(17, 'Approved', 'Approved', 'Graduated', '2025-03-20');

