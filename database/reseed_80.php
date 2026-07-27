<?php
/**
 * PRVTS Database Reseeder - 80 Students with Realistic Data
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use App\Core\Database;

$db = Database::getInstance();

echo "Starting database reseed for 80 postgraduate students...\n";

// Disable foreign key checks for clean truncation
$db->query('SET FOREIGN_KEY_CHECKS = 0');
$db->execute();

$tables = [
    'alert_resolutions',
    'student_remarks',
    'graduation',
    'corrections',
    'viva_records',
    'student_supervisors',
    'examiners',
    'supervisors',
    'students',
    'users'
];

foreach ($tables as $t) {
    $db->query("TRUNCATE TABLE `$t`");
    $db->execute();
}

$db->query('SET FOREIGN_KEY_CHECKS = 1');
$db->execute();

echo "Database truncated successfully.\n";

// 1. Seed Users
$db->query("INSERT INTO `users` (`name`, `email`, `username`, `password`, `role`) VALUES 
('Admin GSGSG', 'admin@uum.edu.my', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Staff Officer', 'staff@uum.edu.my', 'staff', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff')");
$db->execute();

// 2. Seed Supervisors (15)
$supervisorsData = [
    ['Prof. Dr. Ahmad Martadha bin Mohamed', 'martadha@uum.edu.my', '019-4567890', 'School of Government'],
    ['Assoc. Prof. Dr. Zaheruddin bin Othman', 'zaher@uum.edu.my', '012-3456789', 'School of Government'],
    ['Prof. Dr. Engku Ahmad Zaki Engku Alwi', 'engku@uum.edu.my', '013-9876543', 'School of Government'],
    ['Assoc. Prof. Dr. Hisham bin Dzakiria', 'hisham@uum.edu.my', '017-5551234', 'School of Computing'],
    ['Dr. Osman bin Ghazali', 'osman@uum.edu.my', '019-1122334', 'School of Computing'],
    ['Dr. Nor Idayu binti Mahat', 'idayu@uum.edu.my', '013-4455667', 'School of Quantitative Sciences'],
    ['Prof. Dr. Zainal bin Amin', 'zainal@uum.edu.my', '012-9988776', 'School of Business Management'],
    ['Assoc. Prof. Dr. Yusnidah binti Ibrahim', 'yusnidah@uum.edu.my', '019-3344556', 'School of Economics, Finance & Banking'],
    ['Dr. Che Mohd Aziz bin Yaacob', 'aziz@uum.edu.my', '016-7788990', 'School of International Studies'],
    ['Prof. Dr. Rosna binti Awang Hashim', 'rosna@uum.edu.my', '012-6655443', 'School of Applied Psychology, Social Work & Policy'],
    ['Assoc. Prof. Dr. Asmah binti Laili', 'asmah@uum.edu.my', '013-2233445', 'School of Law'],
    ['Dr. Haslinda binti Hassan', 'haslinda@uum.edu.my', '019-8877665', 'School of Tourism, Hospitality & Event Management'],
    ['Prof. Dr. Zulkhairi bin Dahalin', 'zul@uum.edu.my', '012-1122445', 'School of Computing'],
    ['Assoc. Prof. Dr. Fauziah binti Ani', 'fauziah@uum.edu.my', '017-6677889', 'School of Business Management'],
    ['Dr. Mazni binti Omar', 'mazni@uum.edu.my', '013-3322110', 'School of Computing']
];

foreach ($supervisorsData as $s) {
    $db->query("INSERT INTO `supervisors` (`supervisor_name`, `email`, `phone`, `department`) VALUES (:name, :email, :phone, :dept)");
    $db->bind(':name', $s[0]);
    $db->bind(':email', $s[1]);
    $db->bind(':phone', $s[2]);
    $db->bind(':dept', $s[3]);
    $db->execute();
}

// 3. Seed Examiners (20: 10 Internal, 10 External)
$examinersData = [
    // Internal (UUM)
    ['Prof. Dr. Ku Ruhana Ku Mahamud', 'Universiti Utara Malaysia', 'ruhana@uum.edu.my', '019-4112233', 'Internal'],
    ['Assoc. Prof. Dr. Muhammad Fuad bin Othman', 'Universiti Utara Malaysia', 'fuad@uum.edu.my', '012-5544332', 'Internal'],
    ['Dr. Azrina binti Abd Aziz', 'Universiti Utara Malaysia', 'azrina@uum.edu.my', '013-6677889', 'Internal'],
    ['Prof. Dr. Mohd Amy Azhar bin Mohd Harif', 'Universiti Utara Malaysia', 'amyazhar@uum.edu.my', '019-7788990', 'Internal'],
    ['Assoc. Prof. Dr. Bahtiar bin Mohamad', 'Universiti Utara Malaysia', 'bahtiar@uum.edu.my', '012-9900112', 'Internal'],
    ['Dr. Norehan binti Abdullah', 'Universiti Utara Malaysia', 'norehan@uum.edu.my', '017-3344112', 'Internal'],
    ['Prof. Dr. Rushami Zien bin Yusoff', 'Universiti Utara Malaysia', 'rzien@uum.edu.my', '019-2233114', 'Internal'],
    ['Dr. Mass Hareeza binti Ali', 'Universiti Utara Malaysia', 'mass@uum.edu.my', '013-1144556', 'Internal'],
    ['Assoc. Prof. Dr. Nuarrual Hilal bin Md Dahlan', 'Universiti Utara Malaysia', 'nuarrual@uum.edu.my', '012-8877112', 'Internal'],
    ['Dr. Salniza binti Md Salleh', 'Universiti Utara Malaysia', 'salniza@uum.edu.my', '019-6655112', 'Internal'],
    // External
    ['Prof. Dr. Mansor bin Mohd Noor', 'Universiti Malaya (UM)', 'mansor@um.edu.my', '019-3322114', 'External'],
    ['Assoc. Prof. Dr. Sharifah Syahirah Syed Sheikh', 'Universiti Kebangsaan Malaysia (UKM)', 'syahirah@ukm.edu.my', '012-4455667', 'External'],
    ['Prof. Dr. Ahmad Bashawir bin Abdul Ghani', 'Universiti Sains Malaysia (USM)', 'bashawir@usm.my', '013-5566778', 'External'],
    ['Assoc. Prof. Dr. Rohana binti Jani', 'Universiti Putra Malaysia (UPM)', 'rohana@upm.edu.my', '019-8899001', 'External'],
    ['Prof. Dr. Jamaluddin bin Harun', 'Universiti Teknologi Malaysia (UTM)', 'p-jamal@utm.my', '012-7788991', 'External'],
    ['Prof. Dr. Hazman bin Shah Abdullah', 'Universiti Teknologi MARA (UiTM)', 'hazman@uitm.edu.my', '017-9900112', 'External'],
    ['Assoc. Prof. Dr. Mohamad Zainari bin Awang', 'Universiti Sultan Zainal Abidin (UniSZA)', 'zainari@unisza.edu.my', '019-2211443', 'External'],
    ['Prof. Dr. Wan Ahmad Amir Zal bin Wan Ismail', 'Universiti Malaysia Kelantan (UMK)', 'amirzal@umk.edu.my', '013-3344556', 'External'],
    ['Assoc. Prof. Dr. Haryati binti Shafii', 'Universiti Tun Hussein Onn Malaysia (UTHM)', 'haryati@uthm.edu.my', '012-6677889', 'External'],
    ['Prof. Dr. Abdul Razak bin Ahmad', 'Universiti Defence Malaysia (UPNM)', 'razak@upnm.edu.my', '019-8877112', 'External']
];

foreach ($examinersData as $e) {
    $db->query("INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`, `classification`) VALUES (:name, :inst, :email, :phone, :class)");
    $db->bind(':name', $e[0]);
    $db->bind(':inst', $e[1]);
    $db->bind(':email', $e[2]);
    $db->bind(':phone', $e[3]);
    $db->bind(':class', $e[4]);
    $db->execute();
}

echo "Supervisors (15) & Examiners (20) seeded.\n";

// 80 Student Names pool
$names = [
    // Malay
    'Aina Syahirah binti Bakar', 'Mohd Faiz bin Shariff', 'Nurul Aini binti Zulkifli', 'Ahmad Syazwan bin Ismail',
    'Wan Amirah binti Wan Abdullah', 'Khairul Anuar bin Mansor', 'Farah Nabilah binti Rosli', 'Mohd Ezhar bin Shukri',
    'Nur Hanani binti Mustaffa', 'Mohd Fitri bin Ismail', 'Wan Nurul Asyikin binti Wan Din', 'Izwan bin Hamid',
    'Siti Hajar binti Salleh', 'Syed Mohammad bin Syed Ali', 'Muhammad Hafiz bin Ahmad', 'Norazlina binti Abdul Rahman',
    'Mohd Fairuz bin Zakaria', 'Siti Nurhaliza binti Mahadi', 'Khairun Nisa binti Hashim', 'Amirul Asyraf bin Roslan',
    'Nurul Huda binti Othman', 'Ahmad Ridzuan bin Mohamad', 'Faridzal bin Zainal', 'Norain binti Che Omar',
    'Mohd Azlan bin Kassim', 'Suhaila binti Yusof', 'Wan Mohd Azmi bin Wan Hamid', 'Tengku Ahmad Nizam bin Tengku Omar',
    'Nur Farahana binti Ghazali', 'Mohd Hafizuddin bin Razali',
    // Chinese
    'Lee Zhen Kang', 'Tan Wei Sheng', 'Lim Kah Seng', 'Wong Mei Ling', 'Soo Siew Hoon', 'Lau Bik Kiong',
    'Fong Chee Hoe', 'Sim Huey Teng', 'Chan Kar Wai', 'Teh Chun Hoe', 'Alvin Yeoh Jin Tat', 'Ong Su Yi',
    'Amanda Chen Xiao Ling', 'Nicole Ng Poh Yee', 'Chow Yong Kang', 'Khoo Kah Kiat', 'Yap Siew Ting',
    'Goh Boon Chun', 'Teoh Jing Hui', 'Cheah Lay Peng', 'Chung Siew Yee', 'Leong Mei Ling',
    // Indian
    'Deepa A/P Ramesh', 'Divya A/P Kumar', 'Suresh A/L Raman', 'Karthik A/L Munusamy', 'Jaya Lakshmi A/P Shanmugam',
    'Nirosha A/P Kumar', 'Ravi Chandran A/L Perumal', 'Dinesh A/L Mohan', 'Saravanan A/L Muthu', 'Anbarasan A/L Ganesan',
    'Priyanka A/P Vijay', 'Vimalan A/L Shanmuganathan', 'Thalapathy A/L Gengadharan',
    // International
    'Salem Mubarak Al-Hajri', 'Adel Mohammed Al-Ameri', 'Saeed Ahmed Al-Katheri', 'Hassan Mahmoud Al-Zain',
    'Faisal Nasser Al-Harthy', 'Sultan Ali Al-Yemeni', 'Rashid Khaled Al-Mansoori', 'Ibrahim Omar Al-Ghamdi',
    'Fatima Zahra El-Khoury', 'Kwame Osei Mensah', 'Zhang Wei', 'Nguyen Van Minh', 'Mohammed Abdullah Al-Qarni',
    'Tariq Mohammed Al-Busaidi', 'Ahmed Hassan Al-Mansoor'
];

$schools = [
    'School of Government',
    'School of Computing',
    'School of Law',
    'School of Business Management',
    'School of Economics, Finance & Banking',
    'School of International Studies',
    'School of Tourism, Hospitality & Event Management',
    'School of Quantitative Sciences'
];

$programmes = [
    'Doctor of Philosophy (Public Management)',
    'Doctor of Philosophy (Computer Science)',
    'Doctor of Philosophy (Law)',
    'Doctor of Business Administration (DBA)',
    'Master of Science (Managerial Intelligence)',
    'Master of Public Management',
    'Doctor of Philosophy (Economics)',
    'Master of Science (Information Technology)',
    'Doctor of Philosophy (International Relations)',
    'Master of Science (Tourism & Hospitality)'
];

$thesisTitles = [
    'Policy Analysis of E-Government Implementation in Northern Peninsular Malaysia',
    'Machine Learning Framework for Predictive Analytics in Smart Healthcare Systems',
    'Legal Protections for Gig Economy Workers under Malaysian Labor Legislation',
    'Transformational Leadership and Sustainable Financial Performance in ASEAN SMEs',
    'Impact of Digital Financial Literacy on Rural Household Micro-Savings in Kedah',
    'Evaluating Public Administration Reforms in Local Municipal Authorities',
    'Deep Learning Algorithms for Autonomous Drone Navigation in Urban Forestry',
    'Comparative Constitutional Governance: A Study of Malaysia and Singapore Law',
    'Supply Chain Resilience and Risk Mitigation Strategies Post-Global Pandemics',
    'Macroeconomic Determinants of Foreign Direct Investment Flows in Emerging Markets',
    'Cross-Border Security Cooperation in the Straits of Malacca: Geopolitical Perspective',
    'Community-Based Eco-Tourism and Sustainable Livelihood Models in Langkawi Island',
    'Cybersecurity Threat Analysis in Cloud Computing Architecture for Public Sector',
    'Corporate Governance Structures and Intellectual Capital Valuation in Public Listed Firms',
    'Assessing Islamic Banking Products and Consumer Trust in Suburban Communities'
];

$statuses = [
    'Thesis Submitted'      => 12,
    'Examiner Assigned'     => 12,
    'Viva Scheduled'        => 16,
    'Viva Completed'        => 16,
    'Corrections Submitted' => 12,
    'Ready for Senate'      => 6,
    'Graduated'             => 6
];

$currentDate = new DateTime(); // Today 2026-07-27

$studentCount = 0;
foreach ($statuses as $status => $count) {
    for ($i = 0; $i < $count; $i++) {
        $studentCount++;
        $matricNo = (825000 + $studentCount);
        $name = $names[($studentCount - 1) % count($names)];
        $degree = ($studentCount % 5 === 0) ? 'DBA' : (($studentCount % 3 === 0) ? 'Masters' : 'PhD');
        $school = $schools[($studentCount - 1) % count($schools)];
        $programme = $programmes[($studentCount - 1) % count($programmes)];
        $title = $thesisTitles[($studentCount - 1) % count($thesisTitles)];
        $cohort = 'A231 (' . date('Y', strtotime("-1 year")) . ')';
        
        $receiptDate = date('Y-m-d', strtotime('-' . rand(60, 300) . ' days'));

        // 1. Insert Student
        $db->query("INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) 
                    VALUES (:matric, :name, :prog, :school, :degree, :cohort, :receipt, :title, :status)");
        $db->bind(':matric', $matricNo);
        $db->bind(':name', $name);
        $db->bind(':prog', $programme);
        $db->bind(':school', $school);
        $db->bind(':degree', $degree);
        $db->bind(':cohort', $cohort);
        $db->bind(':receipt', $receiptDate);
        $db->bind(':title', $title);
        $db->bind(':status', $status);
        $db->execute();

        $studentId = $db->lastInsertId();

        // 2. Assign Supervisors (1 Main, 50% also 1 Co)
        $mainSupId = rand(1, 15);
        $db->query("INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (:sid, :supid, 'main')");
        $db->bind(':sid', $studentId);
        $db->bind(':supid', $mainSupId);
        $db->execute();

        if ($studentCount % 2 === 0) {
            $coSupId = ($mainSupId % 15) + 1;
            $db->query("INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (:sid, :supid, 'co')");
            $db->bind(':sid', $studentId);
            $db->bind(':supid', $coSupId);
            $db->execute();
        }

        // 3. Build Viva, Corrections, Graduation records based on status
        $internalId = rand(1, 10);
        $externalId = rand(11, 20);
        $chairperson = 'Prof. Dr. ' . explode(' ', $names[($studentCount + 3) % count($names)])[0];

        $vivaData = [
            'student_id' => $studentId,
            'internal_examiner_id' => null,
            'external_examiner_id' => null,
            'chairperson_name' => null,
            'internal_examiner_status' => 'Pending',
            'external_examiner_status' => 'Pending',
            'viva_date' => null,
            'viva_result' => null,
            'honorarium_chairperson' => null,
            'honorarium_internal' => null,
            'honorarium_external' => null,
            'honorarium_refreshment' => null
        ];

        $corrData = [
            'student_id' => $studentId,
            'correction_required' => 1,
            'correction_deadline' => null,
            'corrected_thesis_received_date' => null,
            'supervisor_endorsement_date' => null,
            'final_result' => null
        ];

        $gradData = [
            'student_id' => $studentId,
            'jil_status' => 'Pending',
            'senate_status' => 'Pending',
            'graduation_status' => 'Not Ready',
            'graduation_date' => null
        ];

        // Custom logic per status to create realistic alerts vs clean state
        if (in_array($status, ['Examiner Assigned', 'Viva Scheduled', 'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
            $vivaData['internal_examiner_id'] = $internalId;
            $vivaData['external_examiner_id'] = $externalId;
            $vivaData['chairperson_name'] = $chairperson;
            $vivaData['internal_examiner_email_date'] = date('Y-m-d', strtotime('-20 days'));
            $vivaData['external_examiner_email_date'] = date('Y-m-d', strtotime('-20 days'));
            
            // To create 2 Staff Pending Confirmation alerts:
            if ($status === 'Examiner Assigned' && $studentCount <= 4) {
                $vivaData['internal_examiner_status'] = 'Pending';
                $vivaData['external_examiner_status'] = 'Pending';
            } else {
                $vivaData['internal_examiner_status'] = 'Confirmed';
                $vivaData['external_examiner_status'] = 'Confirmed';
            }
        }

        if (in_array($status, ['Viva Scheduled', 'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
            $vivaData['thesis_to_panel_soft_copy_date'] = date('Y-m-d', strtotime('-25 days'));
            $vivaData['thesis_to_panel_hard_copy_date'] = date('Y-m-d', strtotime('-25 days'));
            $vivaData['internal_examiner_report_date'] = date('Y-m-d', strtotime('-10 days'));

            // Staff Pending Report alert for 2 students:
            if ($status === 'Viva Scheduled' && $studentCount % 4 === 0) {
                $vivaData['internal_examiner_report_date'] = null; // Triggers alert!
            }

            if ($status === 'Viva Scheduled') {
                // Mix of upcoming Vivas (next 15 days) and past Vivas missing result (last 10 days)
                if ($i < 10) {
                    // Upcoming Vivas (triggers Upcoming Viva alert)
                    $vivaData['viva_date'] = date('Y-m-d', strtotime('+' . (3 + $i * 2) . ' days'));
                    $vivaData['viva_result'] = null;
                } else {
                    // Past Vivas (triggers Overdue Viva Outcome alert)
                    $vivaData['viva_date'] = date('Y-m-d', strtotime('-' . (2 + $i) . ' days'));
                    $vivaData['viva_result'] = null;
                }
            } else {
                // Completed, Corrections, Senate, Graduated
                $vivaData['viva_date'] = date('Y-m-d', strtotime('-' . (30 + $studentCount) . ' days'));
                $vivaData['viva_result'] = ($studentCount % 3 === 0) ? 'Pass with Major Corrections' : 'Pass with Minor Corrections';
                $vivaData['turnitin_percentage'] = rand(8, 18) . '%';
            }
        }

        if (in_array($status, ['Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
            // Honorarium logic:
            // For Viva Completed: 60% filled with RM amounts, 40% missing RM amounts (triggers Pending Honorarium alert!)
            if ($status === 'Viva Completed' && $i >= 8) {
                $vivaData['honorarium_chairperson'] = '0.00'; // Missing/0 triggers alert!
                $vivaData['honorarium_internal']    = '0.00';
                $vivaData['honorarium_external']    = '0.00';
                $vivaData['honorarium_refreshment']  = '0.00';
            } else {
                $vivaData['honorarium_chairperson'] = '500.00';
                $vivaData['honorarium_internal']    = '400.00';
                $vivaData['honorarium_external']    = '600.00';
                $vivaData['honorarium_refreshment']  = '150.00';
            }
        }

        if (in_array($status, ['Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
            $deadline = date('Y-m-d', strtotime('-' . rand(5, 30) . ' days'));
            $corrData['correction_deadline'] = $deadline;

            if ($status === 'Corrections Submitted') {
                // Some overdue corrections (triggers Overdue Correction alert)
                if ($i < 4) {
                    $corrData['correction_deadline'] = date('Y-m-d', strtotime('-' . (5 + $i * 3) . ' days'));
                    $corrData['corrected_thesis_received_date'] = null; // Missing triggers alert!
                } elseif ($i < 8) {
                    // Due soon corrections (triggers Correction Due Soon alert)
                    $corrData['correction_deadline'] = date('Y-m-d', strtotime('+' . (2 + $i) . ' days'));
                    $corrData['corrected_thesis_received_date'] = null; // Missing triggers alert!
                } else {
                    // Received > 7 days ago but supervisor endorsement missing (triggers Staff Supervisor Endorsement alert!)
                    $corrData['corrected_thesis_received_date'] = date('Y-m-d', strtotime('-10 days'));
                    $corrData['supervisor_endorsement_date'] = null; // Missing triggers staff alert!
                }
            } else {
                // Ready for Senate / Graduated
                $corrData['corrected_thesis_received_date'] = date('Y-m-d', strtotime('-40 days'));
                $corrData['supervisor_endorsement_date'] = date('Y-m-d', strtotime('-35 days'));
                $corrData['final_result'] = 'Approved by Panel & Main Supervisor';
            }
        }

        if (in_array($status, ['Ready for Senate', 'Graduated'])) {
            $gradData['senate_status'] = 'Approved';
            $gradData['senate_meeting_date'] = date('Y-m-d', strtotime('-20 days'));
            $gradData['senate_meeting_no'] = 'Meeting No. ' . (280 + $studentCount);
            $gradData['jil_status'] = 'Approved';
            $gradData['jil_meeting_date'] = date('Y-m-d', strtotime('-25 days'));
            $gradData['jil_meeting_no'] = 'JIL/' . date('Y') . '/' . (100 + $studentCount);
        }

        if ($status === 'Graduated') {
            $gradData['graduation_status'] = 'Graduated';
            $gradData['graduation_date'] = date('Y-m-d', strtotime('-10 days'));
            $gradData['gais_keyin_date'] = date('Y-m-d', strtotime('-15 days'));
        }

        // Save Viva Record
        $db->query("INSERT INTO `viva_records` (
            `student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`,
            `internal_examiner_email_date`, `internal_examiner_status`,
            `external_examiner_email_date`, `external_examiner_status`,
            `thesis_to_panel_soft_copy_date`, `thesis_to_panel_hard_copy_date`,
            `internal_examiner_report_date`, `viva_date`, `viva_result`, `turnitin_percentage`,
            `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`
        ) VALUES (
            :sid, :ieid, :eeid, :chair,
            :ie_email, :ie_stat,
            :ee_email, :ee_stat,
            :t_soft, :t_hard,
            :ie_rpt, :v_date, :v_res, :turnitin,
            :h_chair, :h_int, :h_ext, :h_ref
        )");
        $db->bind(':sid', $studentId);
        $db->bind(':ieid', $vivaData['internal_examiner_id']);
        $db->bind(':eeid', $vivaData['external_examiner_id']);
        $db->bind(':chair', $vivaData['chairperson_name']);
        $db->bind(':ie_email', $vivaData['internal_examiner_email_date'] ?? null);
        $db->bind(':ie_stat', $vivaData['internal_examiner_status']);
        $db->bind(':ee_email', $vivaData['external_examiner_email_date'] ?? null);
        $db->bind(':ee_stat', $vivaData['external_examiner_status']);
        $db->bind(':t_soft', $vivaData['thesis_to_panel_soft_copy_date'] ?? null);
        $db->bind(':t_hard', $vivaData['thesis_to_panel_hard_copy_date'] ?? null);
        $db->bind(':ie_rpt', $vivaData['internal_examiner_report_date'] ?? null);
        $db->bind(':v_date', $vivaData['viva_date'] ?? null);
        $db->bind(':v_res', $vivaData['viva_result'] ?? null);
        $db->bind(':turnitin', $vivaData['turnitin_percentage'] ?? null);
        $db->bind(':h_chair', $vivaData['honorarium_chairperson'] ?? null);
        $db->bind(':h_int', $vivaData['honorarium_internal'] ?? null);
        $db->bind(':h_ext', $vivaData['honorarium_external'] ?? null);
        $db->bind(':h_ref', $vivaData['honorarium_refreshment'] ?? null);
        $db->execute();

        // Save Corrections Record
        $db->query("INSERT INTO `corrections` (
            `student_id`, `correction_required`, `correction_deadline`,
            `corrected_thesis_received_date`, `supervisor_endorsement_date`, `final_result`
        ) VALUES (:sid, :req, :dead, :recv, :endorse, :final)");
        $db->bind(':sid', $studentId);
        $db->bind(':req', $corrData['correction_required']);
        $db->bind(':dead', $corrData['correction_deadline']);
        $db->bind(':recv', $corrData['corrected_thesis_received_date']);
        $db->bind(':endorse', $corrData['supervisor_endorsement_date']);
        $db->bind(':final', $corrData['final_result']);
        $db->execute();

        // Save Graduation Record
        $db->query("INSERT INTO `graduation` (
            `student_id`, `jil_status`, `jil_meeting_date`, `jil_meeting_no`,
            `senate_status`, `senate_meeting_date`, `senate_meeting_no`,
            `graduation_status`, `graduation_date`, `gais_keyin_date`
        ) VALUES (:sid, :jstat, :jdate, :jno, :sstat, :sdate, :sno, :gstat, :gdate, :gais)");
        $db->bind(':sid', $studentId);
        $db->bind(':jstat', $gradData['jil_status']);
        $db->bind(':jdate', $gradData['jil_meeting_date'] ?? null);
        $db->bind(':jno', $gradData['jil_meeting_no'] ?? null);
        $db->bind(':sstat', $gradData['senate_status']);
        $db->bind(':sdate', $gradData['senate_meeting_date'] ?? null);
        $db->bind(':sno', $gradData['senate_meeting_no'] ?? null);
        $db->bind(':gstat', $gradData['graduation_status']);
        $db->bind(':gdate', $gradData['graduation_date'] ?? null);
        $db->bind(':gais', $gradData['gais_keyin_date'] ?? null);
        $db->execute();

        // Add 1-2 Remarks for some students
        if ($studentCount % 3 === 0) {
            $db->query("INSERT INTO `student_remarks` (`student_id`, `author_name`, `remark_text`, `created_at`) 
                        VALUES (:sid, 'Admin GSGSG', 'Student submitted revised draft for supervisor pre-screening. All compliance checks passed.', NOW())");
            $db->bind(':sid', $studentId);
            $db->execute();
        }
    }
}

echo "Successfully seeded 80 students across all research statuses with matching Viva, Corrections, and Graduation details!\n";
