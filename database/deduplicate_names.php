<?php
/**
 * Deduplicate Academic / Examiner / Supervisor Names in Database & SQL file
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Core\Database;

$db = Database::getInstance();

echo "Starting Comprehensive Name Deduplication & Database Normalization...\n";

// Comprehensive map of canonical name => array of non-canonical variants
$mappings = [
    'DR. MOHAMED FAJIL B. ABDUL BATAU' => [
        'DR. MOHAMED FAJIL ABDUL BATAU',
        'Dr. Mohamed Fajil b. Abdul Batau',
        'DR. MOHAMED FAJIL B ABDUL BATAU'
    ],
    'ASSOC. PROF. DR. AMINURRAASYID BIN YATIBAN' => [
        'ASSOC. PROF. DR. AMINURRAASYID YATIBAN',
        'Prof. Madya Dr. Aminurraasyid Yatiban',
        'PROF. MADYA DR. AMINURRAASYID YATIBAN'
    ],
    'ASSOC. PROF. DR. RAMLI BIN DOLLAH' => [
        'ASSOC. PROF. DR. RAMLI DOLLAH'
    ],
    'ASSOC. PROF. DR. ZAHERAWATI BINTI ZAKARIA' => [
        'ASSOC. PROF. DR. ZAHERAWATI BT. ZAKARIA',
        'ASSOC. PROF. DR. ZAHERAWATI ZAKARIA',
        'PROF. MADYA DR. ZAHERAWATI BINTI ZAKARIA',
        'PROF. MADYA DR. ZAHERAWATI BT ZAKARIA'
    ],
    'DR. ABD. RAHIM BIN ROMLE' => [
        'DR. ABD. RAHIM ROMLE',
        'DR. ABD. RAHIM ROMLEE',
        'DR. ABD. RAHIM BIN ROMLEE',
        'Dr. Abd. Rahim Romle',
        'ASSOC. PROF. DR. ABD. RAHIM BIN ROMLE',
        'ASSOC. PROF. DR. ABD. RAHIM ROMLE',
        'Dr. Rahim Romle'
    ],
    'DR. AHMAD EDWIN BIN MOHAMED' => [
        'DR. AHMAD EDWIN MOHAMED'
    ],
    'DR. AIN ZURAINI BINTI ZIN ARIS' => [
        'DR. AIN ZURAINI ZIN ARIS'
    ],
    'DR. AIZAT BIN KHAIRI' => [
        'DR. AIZAT KHAIRI',
        'Dr. Aizat bin Khairi'
    ],
    'DR. HUSSEIN MOHAMMED ESMAIL ABU AL-REJAL' => [
        'DR. HUSSEIN ESMAIL ABU AL-REJAL',
        'DR. HUSSEIN MOHAMMED ESMAIL ABU AL - REJAL',
        'DR. HUSSEIN MOHAMMED ESMAIL ABU AL- REJAL',
        'Dr. Hussein Mohammed Esmail Abu Al-Rejal'
    ],
    'DR. KAMARUL ZAMAN BIN HAJI YUSOFF' => [
        'DR. KAMARUL ZAMAN HAJI YUSOFF',
        'Dr. Kamarul Zaman bin Haji Yusoff'
    ],
    'DR. MOHD AZWARDI BIN MD. ISA' => [
        'DR. MOHD  AZWARDI BIN MD. ISA',
        'DR. MOHD AZWARDI MD. ISA',
        'DR. MOHD AZWARDI MD ISA'
    ],
    'DR. WAN NURISMA AYU BINTI WAN ISMAIL' => [
        'DR. WAN NURISMA AYU WAN ISMAIL',
        'Dr. Wan Nurisma Ayu Binti Wan Ismail'
    ],
    'PROF. DR. AMINUDDIN HASSAN' => [
        'PROF DR. AMINUDDIN HASSAN',
        'PROF. AMINUDDIN HASSAN'
    ],
    'PROF. DATO\' DR. HJ. MOHAMAD NASIR BIN HJ. SALUDIN' => [
        'PROF. DATO\' DR. DR. HJ. MOHAMAD NASIR BIN HJ SALUDIN',
        'PROF. DATO\' DR. HJ. MOHAMAD NASIR HJ. SALUDIN',
        'PROF. DATO’ DR. HJ. MOHAMAD NASIR BIN HJ. SALUDIN'
    ],
    'PROF. DATO\' DR. NASRUDIN BIN MOHAMMED' => [
        'PROF. DATO\' DR. NASRUDIN BIN MOHAMED',
        'PROF. DATO’ DR. NASRUDIN BIN MOHAMMED',
        'PROF. DATO’ DR NASRUDIN BIN MOHAMMED'
    ],
    'PROF. DR. AHMAD MARTADHA BIN MOHAMED' => [
        'PROF. DR. AHMAD MARTADHA MOHAMED',
        'Prof. Dr. Ahmad Martadha Mohamed',
        'Prof. Dr. Ahmad Martadha bin Mohamed',
        'Prof. Dr. Ahmad Martadha Bin Mohamed'
    ],
    'PROF. DR. HARLINDA BINTI ABDUL WAHAB' => [
        'PROF. DR. HARLINDA ABDUL WAHAB',
        'Prof. Dr. Harlinda Bt Abdul Wahab',
        'PROF. DR. HARLIDA ABDUL WAHAB'
    ],
    'PROF. DR. MOHAMED GAMAL ABOELMAGED' => [
        'PROF. DR. GAMAL ABOELMAGED'
    ],
    'PROF. DR. YARINA BIN AHMAD' => [
        'PROF. DR. YARINA AHMAD',
        'PROF. DR. YARINA BINTI AHMAD'
    ],
    'ASSOC. PROF. DR. NARENTHEREN A' => [
        'PROF. MADYA . DR. NARENTHEREN A',
        'ASSOC PROF. DR. NARENTHEREN A',
        'Prof. Madya Dr. Narentheren a'
    ],
    'ASSOC. PROF. DR. KAMARUL AZMAN BIN KHAMIS' => [
        'PROF. MADYA DR. KAMARUL AZMAN',
        'PROF. MADYA DR. KAMARUL AZMAN KAMIS',
        'Prof. Madya Dr. Kamarul Azman Bin Khamis',
        'ASSOC. PROF DR. KAMARUL AZMAN BIN KHAMIS',
        'Prof. Madya Dr. Kamarul Azman'
    ],
    'ASSOC. PROF. DR. MUHAMMAD NOOR HABIBI BIN HJ. LONG' => [
        'PROF. MADYA DR. MUHAMAD NOOR HABIBI B. HAJI LONG',
        'PROF. MADYA DR. MUHAMMAD NOOR HABIBI BIN HJ. LONG',
        'ASSOC. PROF. DR. MUHAMAD NOOR HABIBI BIN HJ. LONG',
        'Prof. Madya Dr. Muhamad Noor Habibi b. Hj. Long'
    ],
    'PROF. TPR. DR. DANI BIN SALLEH' => [
        'PROF. TPR. DR. DANI BIN SALEH',
        'Prof. TPr. Dr. Dani bin Salleh',
        'PROF. TPR. DR. DANI SALLEH'
    ],
    'ASSOC. PROF. DR. SAMER ALI HUSSEIN AL-SHAMI' => [
        'PROF MADYA DR. SAMER ALI HUSSEIN AL-SHAMI',
        'ASSOC PROF. DR SAMER ALI HUSSEIN AL-SHAMI',
        'PROF. MADYA DR. SAMER ALI AL-SHAMI',
        'ASSOC. PROF. DR. SAMEER ALI HUSSEIN AL-SHAMI'
    ],
    'ASSOC. PROF. DR. MOHAMAD SHAHARUDIN BIN SAMSURIJAN' => [
        'PROF. MADYA DR. MOHAMAD SHAHARUDIN SAMSURIJAN',
        'ASSOC. PROF. DR. MOHAMAD SHAHARUDIN BIN SAMSURIJAN',
        'PROF. MADYA DR. MUHAMAD SHAHARUDIN SAMSURIJAN'
    ],
    'ASSOC. PROF. TS. DR. MOHD ZUKIME BIN MAT JUNOH' => [
        'ASSOC. PROF. TS. DR. MOHD ZUKIME HJ. MAT JUNOH',
        'ASSOC. PROF TS. DR. MOHD ZUKIME MAT JUNOH'
    ],
    'ASSOC. PROF. DR. MONTHER ABDULKAREEM AL-QUDAH' => [
        'ASSOC. PROF. DR. MONTHER ABDULKAREEM AL QUDAH',
        'PROF. MADYA DR. MONTHER ABDULKAREEM AL QUDAH'
    ],
    'ASSOC. PROF. DR. HASLINDA BINTI MOHD ANUAR' => [
        'ASSOC PROF. DR. HASLINDA MOHD ANUAR',
        'Prof. Madya Dr. Haslinda binti Mohd. Anuar',
        'ASSOC. PROF. DR. HASLINDA MOHD ANUAR',
        'PROF. MADYA DR. HASLINDA BINTI MOHD. ANUAR',
        'PROF. DR. HASLINDA MOHD ANUAR'
    ],
    'ASSOC. PROF. DR. ROHIZAN BINTI HALIM' => [
        'ASSOC. PROF. DR. ROHIZAN HALIM',
        'PROF. MADYA DR. ROHIZAN BINTI HALIM'
    ],
    'ASSOC. PROF. DR. AHMAD ZUBIR BIN IBRAHIM' => [
        'Prof. Madya Dr. Ahmad Zubir Ibrahim',
        'PROF. MADYA DR. AHMAD ZUBIR BIN IBRAHIM',
        'Prof. Madya Dr. Ahmad Zubir bin Ibrahim'
    ],
    'ASSOC. PROF. DR. ROZILA BINTI AHMAD' => [
        'Prof. Madya Dr. Rozila binti Ahmad',
        'ASSOC PROF. DR. ROZILA AHMAD',
        'ASSOC. PROF. DR. ROZILA BINTI AHMAD'
    ],
    'ASSOC. PROF. DR. SALMI MOHD ISA' => [
        'ASSOC PROF. DR. SALMI MOHD ISA',
        'Prof. Madya Dr. Salmi Mohd Isa'
    ],
    'ASSOC. PROF. DR. MAZEN MOHAMMED FAREA' => [
        'PROF. MADYA DR. MAZEN MOHAMMED FAREA'
    ],
    'PROF. DR. MOHD. MIZAN BIN MOHAMMAD ASLAM' => [
        'PROF. DR MOHD MIZAN BIN MOHAMMAD ASLAM',
        'PROF. DR. MOHD MIZAN BIN MOHAMMAD ASLAM'
    ],
    'DR. MUHAMMAD HAFIZ BIN BADARULZAMAN' => [
        'MUHAMMAD HAFIZ BIN BADARULZAMAN',
        'Dr. Muhammad Hafiz bin Badarulzaman'
    ],
    'PROF. DR. ASMAT NIZAM BIN ABDUL TALIB' => [
        'PROF. DR. ASMAT NIZAM ABDUL TALIB'
    ],
    'ASSOC. PROF. DR. HAMIMI BT OMAR' => [
        'Prof. Madya Dr. Hamimi Bt Omar',
        'ASSOC. PROF. DR. HAMIMI BT OMAR'
    ],
    'ASSOC. PROF. DR. MOHD NA\'EIM BIN AJIS' => [
        'PROF. MADYA DR. MOHD NA\'EIM BIN AJIS',
        'ASSOC. PROF. DR. MOHD NA\'EIM BIN AJIS'
    ],
    'ASSOC. PROF. DR. MD RABIUL ISLAM' => [
        'ASSOC PROF. DR. MD RABIUL ISLAM',
        'ASSOC. PROF. DR. RABIUL ISLAM'
    ],
    'ASSOC. PROF. DR. BAKRI BIN MAT' => [
        'ASSOC. PROF. DR. BAKRI MAT',
        'PROF. MADYA DR. BAKRI BIN MAT',
        'ASSOC PROF. DR. BAKRI MAT',
        'Prof. Madya Dr. Bakri Mat'
    ],
    'PROF. MADYA PMGR. SR. DR. MOHAMAD SUKERI BIN KHALID' => [
        'ASSOC PROF. DR. MOHAMAD SUKERI KHALID',
        'Prof. Madya PMgr. Sr. Dr. Mohamad Sukeri bin Khalid',
        'PROF. MADYA PMGR SR. DR. MOHAMAD SUKERI BIN KHALID'
    ],
    'DR. NOOR AZURA BINTI AZMAN' => [
        'DR. NOOR AZURA AZMAN'
    ],
    'DR. ALISHA BINTI ISMAIL' => [
        'DR. ALISHA ISMAIL',
        'DR. ALISHA BT. ISMAIL'
    ],
    'ASSOC. PROF. DR. NIK AB. HALIM BIN NIK ABDULLAH' => [
        'ASSOC PROF. DR. NIK AB. HALIM NIK ABDULLAH @ ABDULLAH',
        'PROF. MADYA. DR. NIK AB HALIM BIN NIK ABDULLAH',
        'ASSOC. PROF. DR. NIK AB. NIK HALIM NIK ABDULLAH',
        'Prof. Madya Dr. Nik Ab. Halim bin Nik Abdullah @ Abdullah'
    ],
    'ASSOC. PROF. DR. JOHAN AFENDI BIN IBRAHIM' => [
        'ASSOC. PROF. DR. JOHAN AFENDI IBRAHIM',
        'PROF. MADYA DR. JOHAN AFENDI BIN IBRAHIM',
        'ASSOC.PROF. DR. JOHAN AFENDI BIN IBRAHIM',
        'Prof. Madya Dr. Johan Afendi bin Ibrahim',
        'Prof. Madya Dr. Johan Afendi Bin Ibrahim'
    ],
    'ASSOC. PROF. DR. ZAWIYAH BINTI MOHD ZAIN' => [
        'PROF. MADYA DR. ZAWIYAH BINTI MOHD ZAIN',
        'ASSOC. PROF. DR. ZAWIYAH BINTI MOHD. ZAIN',
        'Prof. Madya Dr. Zawiyah binti Mohd. Zain'
    ],
    'DR. SHAZWANIS BINTI SHUKRI' => [
        'DR. SHAZWANIS SHUKRI',
        'Dr. Shazwanis Binti Shukri'
    ],
    'ASSOC. PROF. DR. MOHAMMAD ZAKI BIN AHMAD' => [
        'ASSOC. PROF DR MOHAMMAD ZAKI BIN AHMAD',
        'PROF. MADYA DR. MOHAMMAD ZAKI BIN AHMAD',
        'ASSOC.PROF. DR. MOHAMAD ZAKI BIN AHMAD'
    ],
    'SR. DR. FARAHIYAH BINTI FADZIL' => [
        'SR. DR. FARAHIYAH FADZIL'
    ],
    'ASSOC. PROF. DR. ZAHERUDDIN BIN OTHMAN' => [
        'PROF. MADYA DR. ZAHERUDDIN BIN OTHMAN',
        'ASSOC. PROF. DR. ZAHERUDDIN OTHMAN',
        'Prof. Madya Dr. Zaheruddin bin Othman',
        'Prof. Madya Dr. Zaheruddin Othman'
    ],
    'ASSOC. PROF. DR. NOR AZLINA BINTI MOHD NOOR' => [
        'PROF. MADYA DR. NOR AZLINA BINTI MOHD NOOR',
        'ASSOC. PROF. DR. NOR AZLINA MOHD NOOR',
        'ASSOC PROF. DR. NOR AZLINA MOHD NOOR'
    ],
    'DR. LINA MUNIRAH BINTI KAMARUDIN' => [
        'Dr. Lina Munirah binti  Kamarudin'
    ],
    'ASSOC. PROF. DR. SITI DARWINDA BINTI MOHAMED PERO' => [
        'PROF. MADYA DR. SITI DARWINDA BINTI MOHAMED PERO',
        'DR. SITI DARWINDA BINTI MOHAMED PERO',
        'ASSOC PROF. DR. SITI DARWINDA MOHAMED PERO',
        'ASSOC. PROF. DR. DARWINDA  MOHAMED PERO'
    ],
    'DR. MUHAMMAD ALI RIDHA BIN NORMAN' => [
        'DR. MUHAMMAD ALI RIDHA NORMAN',
        'Dr. Muhammad Ali Ridha',
        'DR. ALI RIDHA BIN NORMAN'
    ],
    'ASSOC. PROF. DR. ZAINAL BIN MD. ZAN' => [
        'Prof. Madya Dr. Zainal bin Md. Zan',
        'ASSOC PROF. DR. ZAINAL MD. ZAN',
        'PROF. MADYA DR. ZAINAL BIN MD ZAN',
        'ASSOC. PROF. DR. ZAINAL MD ZAN',
        'PROF.MADYA DR. ZAINAL MD ZAN',
        'PROF. MADYA DR. ZAINAL BIN MD. ZAN'
    ],
    'DR. REDHWAN AHMED ALI AL-DHAMARI' => [
        'DR. REDHWAN AHMED ALI - DHAMARI',
        'DR. REDHWAN AHMED ALI AL- DHAMARI'
    ],
    'DR. ZAINAB SENAN MAHMOD ATTAR BASHI' => [
        'DR. ZAINAB SENAN MAHMOD ATTAR'
    ],
    'ASSOC. PROF. DR. MOHAMAD FAISOL BIN KELING' => [
        'Prof. Madya Dr. Mohamad Faisol bin Keling',
        'PROF. MADYA. DR. MOHAMAD FAISOL BIN KELING',
        'PROF. MADYA DR. MOHD FAISOL BIN KELING'
    ],
    'ASSOC. PROF. DR. ALIAS BIN AZHAR' => [
        'ASSOC. PROF. DR. ALIAS AZHAR',
        'Prof. Madya Dr. Alias bin Azhar'
    ],
    'ASSOC. PROF. DR. NAZLI ISMAIL @ NAWANG' => [
        'ASSOC. PROF. DR. NAZLI ISMAIL@NAWANG',
        'ASSOC PROF. DR. NAZLI ISMAIL@NAWANG'
    ],
    'ASSOC. PROF. DR. YUSRAMIZZA BINTI MD ISA @ YUSOFF' => [
        'ASSOC. PROF. DR. YUSRAMIZZA MD ISA @YUSUFF',
        'PROF. MADYA DR. YUSRAMIZZA BINTI MD ISA @YUSUF',
        'Prof. Madya Dr. Yusramizza Binti Md Isa @ Yusuff',
        'PROF. MADYA DR. YUSRAMIZZA MD ISA @ YUSUFF',
        'Prof. Madya Dr. Yusramizza Md. Isa @ Yusuff',
        'PROF. MADYA DR. YUSRMIZZA BINTI MD ISA @ YUSUFF'
    ],
    'ASSOC. PROF. DR. AZILA AZMI' => [
        'PROF. MADYA DR. AZILA AZMI'
    ],
    'ASSOC. PROF. DR. MAHADIR BIN LADISMA @ AWIS' => [
        'PROF MADYA DR. MAHADIR BIN LADISMA @ AWIS',
        'PROF. MADYA DR. MAHADIR LADISMA @ AWIS'
    ],
    'ASSOC. PROF. DR. MAHAZIR ISMAIL' => [
        'ASSOC PROF DR. MAHAZIR ISMAIL',
        'Assoc. Prof. Dr. Mahazir Ismail'
    ],
    'PROF. DR. BADARIAH BINTI HAJI DIN' => [
        'PROF. DR. BADARIAH HAJI DIN',
        'PROF. DR. BADARIAH BIN HJ. DIN',
        'Prof. Dr. Badariah binti Haji Din'
    ],
    'ASSOC. PROF. DR. ROZITA BINTI ABDUL MUTALIB' => [
        'PROF. MADYA DR. ROZITA BINTI ABDUL MUTALIB',
        'Prof. Madya Dr. Rozita binti Abdul Mutalib',
        'ASSOC. PROF. DR. ROZITA ABDUL MUTALIB',
        'PROF. MADYA DR. ROZITA BINTI MUTALIB'
    ],
    'ASSOC. PROF. DR. ZURYATI BINTI MOHAMED YUSOFF' => [
        'ASSOC. PROF. DR. ZURYATI BT. MOHAMED YUSOFF',
        'ASSOC PROF. DR. ZURYATI MOHAMED YUSOFF',
        'Prof. Madya Dr. Zuryati Bt. Mohamed Yusoff'
    ],
    'ASSOC. PROF. DR. NOR ANITA BINTI ABDULLAH' => [
        'Prof Madya Dr. Nor Anita binti Abdullah',
        'Prof. Madya Dr. Nor Anita Abdullah',
        'ASSOC. PROF. DR. ANITA ABDULLAH'
    ],
    'PROF. DR. MOHD HANIFF BIN JEDIN' => [
        'PROF. MOHD HANIFF BIN JEDIN',
        'PROF. DR. MOHD HANIFF JEDIN',
        'ASSOC. PROF. DR. MOHD HANIFF BIN JEDIN',
        'PROF. DR HANIFF BIN JEDIN'
    ],
    'ASSOC. PROF. DR. ROZITA BINTI ARSHAD' => [
        'Prof. Madya Dr. Rozita binti Arshad',
        'PROF. MADYA DR. ROZITA BINTI ARSHAD'
    ],
    'ASSOC. PROF. DR. HAMIDI BIN ISMAIL' => [
        'Prof. Madya Dr. Hamidi bin Ismail'
    ],
    'ASSOC. PROF. DR. ROHANA BINTI ABDUL RAHMAN' => [
        'ASSOC PROF. DR. ROHANA ABDUL RAHMAN',
        'Prof. Madya Dr. Rohana binti Abdul Rahman',
        'PROF. MADYA DR. ROHANA BINTI ABDUL RAHMAN'
    ],
    'ASSOC. PROF. DR. MOHD ZAKHIRI BIN MD. NOR' => [
        'ASSOC. PROF. DR. ZAKHIRI MD NOR',
        'Prof. Madya Dr. Mohd Zakhiri bin Md. Nor',
        'PROF. MADYA DR. MOHD ZAKHIRI BIN MD. NOR'
    ],
    'ASSOC. PROF. DR. MOHAMMAD AZAM BIN HUSSAIN' => [
        'ASSOC. PROF. DR. MOHAMMAD AZAM HUSSAIN',
        'Prof. Madya Dr. Mohammad Azam bin Hussain'
    ],
    'DR. SYED SULTAN BEE BINTI PACKEER MOHAMED' => [
        'DR. SYED SULTAN BEE PACKEER MOHAMED'
    ],
    'ASSOC. PROF. DR. FAKHRORAZI BIN AHMAD' => [
        'ASSOC. PROF. DR. FAKHRORAZI AHMAD',
        'ASSOC PROF. DR. FAKHRORAZI AHMAD',
        'Prof. Madya Dr. Fakhrorazi bin Ahmad'
    ],
    'PROF. DR. ZAINAL AMIN BIN AYUB' => [
        'PROF. DR. ZAINAL AMIN AYUB'
    ],
    'ASSOC. PROF. TS. DR. AZLIZAN BIN TALIB' => [
        'ASSOC. PROF. TS. DR. AZLIZAN TALIB',
        'PROF. MADYA TS. DR. AZLIZAN BIN TALIB',
        'ASSOC. PROF. TS . DR. AZLIZAN TALIB',
        'PROF. MADYA TS. DR. AZLIZAN  BIN TALIB'
    ],
    'ASSOC. PROF. DR. SALWANI BINTI HJ. ARBAK' => [
        'ASSOC. PROF. DR. SALWANI HJ. ARBAK',
        'ASSOC. PROF. DR. SALWANI BINTI HJ. ARBAK',
        'PROF. MADYA DR. SALWANI BINTI HJ ARBAK',
        'PROF. MADYA DR. SALWANI BINTI HJ. ARBAK',
        'Prof. Madya Dr. Salwani binti Hj. Arbak',
        'ASSOC. PROF. DR. SALWANI BINTI HJ. ABRAK'
    ],
    'DR. SHARIF SHOFIRUN BIN SHARIF ALI' => [
        'Dr. Sharif Shofirun bin Sharif Ali'
    ],
    'PROF. MADYA DR. TUAN PAH ROKIAH BINTI SYED HUSSAIN' => [
        'Prof. Madya Dr. Tuan Pah Rokiah binti Syed Hussain'
    ]
];

try {
    // 1. UPDATE VIVA_RECORDS CHAIRPERSON NAMES
    echo "\n[1/3] Normalizing chairperson_name in viva_records...\n";
    $chairCount = 0;

    foreach ($mappings as $canonical => $variants) {
        $allSearch = array_merge([$canonical], $variants);
        foreach ($allSearch as $v) {
            $db->query("UPDATE viva_records SET chairperson_name = :canonical WHERE chairperson_name = :variant OR chairperson_name LIKE :variant_like");
            $db->bind(':canonical', $canonical);
            $db->bind(':variant', $v);
            $db->bind(':variant_like', $v . '%');
            $db->execute();
            $chairCount += $db->rowCount();
        }
    }
    echo "  Updated {$chairCount} chairperson records.\n";

    // 2. DEDUPLICATE SUPERVISORS
    echo "\n[2/3] Deduplicating supervisors table...\n";
    $supCount = 0;

    foreach ($mappings as $canonical => $variants) {
        $allVariants = array_values(array_unique(array_merge([$canonical], $variants)));
        
        $placeholders = implode(',', array_fill(0, count($allVariants), '?'));
        $db->query("SELECT supervisor_id, supervisor_name FROM supervisors WHERE supervisor_name IN ($placeholders)");
        $rows = $db->resultSet($allVariants);

        if (count($rows) > 0) {
            $primaryId = null;
            $dupIds = [];

            foreach ($rows as $r) {
                if ($r['supervisor_name'] === $canonical && !$primaryId) {
                    $primaryId = $r['supervisor_id'];
                } else {
                    $dupIds[] = $r['supervisor_id'];
                }
            }

            if (!$primaryId && !empty($dupIds)) {
                $primaryId = array_shift($dupIds);
            }

            if ($primaryId) {
                $db->query("UPDATE supervisors SET supervisor_name = :canonical WHERE supervisor_id = :id");
                $db->bind(':canonical', $canonical);
                $db->bind(':id', $primaryId);
                $db->execute();
            }

            foreach ($dupIds as $dupId) {
                if ($dupId == $primaryId) continue;

                $db->query("SELECT student_id, role FROM student_supervisors WHERE supervisor_id = :dupId");
                $db->bind(':dupId', $dupId);
                $links = $db->resultSet();

                foreach ($links as $link) {
                    $sId = $link['student_id'];
                    $db->query("SELECT id FROM student_supervisors WHERE student_id = :sId AND supervisor_id = :pId");
                    $db->bind(':sId', $sId);
                    $db->bind(':pId', $primaryId);
                    $existing = $db->single();

                    if ($existing) {
                        $db->query("DELETE FROM student_supervisors WHERE student_id = :sId AND supervisor_id = :dupId");
                        $db->bind(':sId', $sId);
                        $db->bind(':dupId', $dupId);
                        $db->execute();
                    } else {
                        $db->query("UPDATE student_supervisors SET supervisor_id = :pId WHERE student_id = :sId AND supervisor_id = :dupId");
                        $db->bind(':pId', $primaryId);
                        $db->bind(':sId', $sId);
                        $db->bind(':dupId', $dupId);
                        $db->execute();
                    }
                }

                $db->query("DELETE FROM supervisors WHERE supervisor_id = :dupId");
                $db->bind(':dupId', $dupId);
                $db->execute();
                $supCount++;
            }
        }
    }
    echo "  Merged & deleted {$supCount} duplicate supervisor rows.\n";

    // 3. DEDUPLICATE EXAMINERS
    echo "\n[3/3] Deduplicating examiners table...\n";
    $examCount = 0;

    foreach ($mappings as $canonical => $variants) {
        $allVariants = array_values(array_unique(array_merge([$canonical], $variants)));
        
        $placeholders = implode(',', array_fill(0, count($allVariants), '?'));
        $db->query("SELECT examiner_id, examiner_name FROM examiners WHERE examiner_name IN ($placeholders)");
        $rows = $db->resultSet($allVariants);

        if (count($rows) > 0) {
            $primaryId = null;
            $dupIds = [];

            foreach ($rows as $r) {
                if ($r['examiner_name'] === $canonical && !$primaryId) {
                    $primaryId = $r['examiner_id'];
                } else {
                    $dupIds[] = $r['examiner_id'];
                }
            }

            if (!$primaryId && !empty($dupIds)) {
                $primaryId = array_shift($dupIds);
            }

            if ($primaryId) {
                $db->query("UPDATE examiners SET examiner_name = :canonical WHERE examiner_id = :id");
                $db->bind(':canonical', $canonical);
                $db->bind(':id', $primaryId);
                $db->execute();
            }

            foreach ($dupIds as $dupId) {
                if ($dupId == $primaryId) continue;

                $db->query("UPDATE viva_records SET internal_examiner_id = :pId WHERE internal_examiner_id = :dupId");
                $db->bind(':pId', $primaryId);
                $db->bind(':dupId', $dupId);
                $db->execute();

                $db->query("UPDATE viva_records SET external_examiner_id = :pId WHERE external_examiner_id = :dupId");
                $db->bind(':pId', $primaryId);
                $db->bind(':dupId', $dupId);
                $db->execute();

                $db->query("SELECT student_id, role FROM student_examiners WHERE examiner_id = :dupId");
                $db->bind(':dupId', $dupId);
                $links = $db->resultSet();

                foreach ($links as $link) {
                    $sId = $link['student_id'];
                    $db->query("SELECT id FROM student_examiners WHERE student_id = :sId AND examiner_id = :pId");
                    $db->bind(':sId', $sId);
                    $db->bind(':pId', $primaryId);
                    $existing = $db->single();

                    if ($existing) {
                        $db->query("DELETE FROM student_examiners WHERE student_id = :sId AND examiner_id = :dupId");
                        $db->bind(':sId', $sId);
                        $db->bind(':dupId', $dupId);
                        $db->execute();
                    } else {
                        $db->query("UPDATE student_examiners SET examiner_id = :pId WHERE student_id = :sId AND examiner_id = :dupId");
                        $db->bind(':pId', $primaryId);
                        $db->bind(':sId', $sId);
                        $db->bind(':dupId', $dupId);
                        $db->execute();
                    }
                }

                $db->query("DELETE FROM examiners WHERE examiner_id = :dupId");
                $db->bind(':dupId', $dupId);
                $db->execute();
                $examCount++;
            }
        }
    }
    echo "  Merged & deleted {$examCount} duplicate examiner rows.\n";

    echo "\nDatabase name deduplication completed successfully!\n";

} catch (\Throwable $e) {
    echo "Error during deduplication: " . $e->getMessage() . "\n";
}

