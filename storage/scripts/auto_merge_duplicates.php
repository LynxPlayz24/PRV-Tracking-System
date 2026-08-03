<?php
/**
 * Strict & Intelligent Academic Name Deduplication Engine
 */

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

use App\Core\Database;

$db = Database::getInstance();

echo "=========================================================\n";
echo " STRICT ACADEMIC NAME DEDUPLICATION & MERGER\n";
echo "=========================================================\n\n";

/**
 * Extract clean name tokens (ignoring titles and bin/binti)
 */
function getCoreTokens(string $name): array {
    $n = mb_strtoupper(trim($name), 'UTF-8');
    $n = str_replace(["’", "‘", "`", "'", ".", ",", "(", ")", "-"], " ", $n);
    
    $titles = [
        'ASSOC PROF', 'ASSOC', 'PROFESSOR', 'PROF MADYA', 'PROF DATO', 'PROF DR', 'PROF TPR', 'PROF', 'MADYA',
        'DATO', 'DATUK', 'DATIN', 'SR', 'IR', 'TS', 'TPR', 'HJ', 'HAJI', 'HJH', 'HAJAH', 'BIN', 'BINTI', 'BT', 'B',
        'AL', 'A/L', 'A/P', 'DEAN', 'CHAIRPERSON', 'PMGR'
    ];
    
    $tokens = preg_split('/\s+/', $n);
    $filtered = [];
    foreach ($tokens as $t) {
        $tClean = trim($t);
        if (empty($tClean)) continue;
        if (in_array($tClean, $titles)) continue;
        $filtered[] = $tClean;
    }
    
    return array_values($filtered);
}

/**
 * Compare two sets of core tokens to determine if they represent the SAME person
 */
function isSamePerson(array $tokens1, array $tokens2): bool {
    if (empty($tokens1) || empty($tokens2)) return false;
    
    // Normalize collapsed characters (consecutive duplicates like R/RR or S/SS)
    $c1 = array_map(fn($t) => preg_replace('/(.)\1+/', '$1', $t), $tokens1);
    $c2 = array_map(fn($t) => preg_replace('/(.)\1+/', '$1', $t), $tokens2);
    
    // Sort tokens alphabetically
    $s1 = $c1; sort($s1);
    $s2 = $c2; sort($s2);
    
    // Exact normalized token match
    if (implode(' ', $s1) === implode(' ', $s2)) {
        return true;
    }
    
    // If one is a subset of the other (e.g. ['AMINURRAASYID', 'YATIBAN'] vs ['AMINURRAASYID', 'BIN', 'YATIBAN'])
    $minCount = min(count($c1), count($c2));
    $intersect = array_intersect($c1, $c2);
    if ($minCount >= 2 && count($intersect) >= $minCount) {
        return true;
    }
    
    // Check token-by-token fuzzy match if count is equal
    if (count($c1) === count($c2) && count($c1) >= 2) {
        $mismatches = 0;
        for ($k = 0; $k < count($c1); $k++) {
            $w1 = $c1[$k];
            $w2 = $c2[$k];
            if ($w1 !== $w2) {
                if (levenshtein($w1, $w2) <= 2 && min(strlen($w1), strlen($w2)) > 4) {
                    // Small typo in a long word (e.g. AMINURAASYID vs AMINURRAASYID)
                    continue;
                } else {
                    $mismatches++;
                }
            }
        }
        if ($mismatches === 0) return true;
    }
    
    return false;
}

/**
 * Score canonical quality of a name to choose primary record
 */
function scoreQuality(string $name): int {
    $score = strlen($name);
    if (str_contains($name, 'ASSOC. PROF. DR.')) $score += 100;
    if (str_contains($name, 'PROF. DR.')) $score += 80;
    if (str_contains($name, 'DR.')) $score += 50;
    if (str_contains($name, 'BIN ') || str_contains($name, 'BINTI ')) $score += 40;
    return $score;
}

// 1. PROCESS SUPERVISORS TABLE
echo "[1] Processing supervisors table...\n";
$db->query("SELECT supervisor_id, supervisor_name FROM supervisors");
$supervisors = $db->resultSet();

$visitedSup = [];
$supClusters = [];

for ($i = 0; $i < count($supervisors); $i++) {
    if (isset($visitedSup[$i])) continue;
    $s1 = $supervisors[$i];
    $t1 = getCoreTokens($s1['supervisor_name']);
    $cluster = [$s1];
    
    for ($j = $i + 1; $j < count($supervisors); $j++) {
        if (isset($visitedSup[$j])) continue;
        $s2 = $supervisors[$j];
        $t2 = getCoreTokens($s2['supervisor_name']);
        
        if (isSamePerson($t1, $t2)) {
            $visitedSup[$j] = true;
            $cluster[] = $s2;
        }
    }
    
    if (count($cluster) > 1) {
        $supClusters[] = $cluster;
    }
}

echo "Found " . count($supClusters) . " supervisor duplicate clusters.\n";
$supMerged = 0;
$allReplacements = [];

foreach ($supClusters as $cluster) {
    usort($cluster, fn($a, $b) => scoreQuality($b['supervisor_name']) <=> scoreQuality($a['supervisor_name']));
    $primary = $cluster[0];
    $primaryId = $primary['supervisor_id'];
    $canonicalName = $primary['supervisor_name'];
    
    echo "  Primary: [{$primaryId}] {$canonicalName}\n";
    
    for ($k = 1; $k < count($cluster); $k++) {
        $dup = $cluster[$k];
        $dupId = $dup['supervisor_id'];
        $dupName = $dup['supervisor_name'];
        
        echo "    <- Merging duplicate: [{$dupId}] {$dupName}\n";
        $allReplacements[$dupName] = $canonicalName;
        
        $db->query("SELECT student_id FROM student_supervisors WHERE supervisor_id = :dupId");
        $db->bind(':dupId', $dupId);
        foreach ($db->resultSet() as $link) {
            $sId = $link['student_id'];
            $db->query("SELECT id FROM student_supervisors WHERE student_id = :sId AND supervisor_id = :pId");
            $db->bind(':sId', $sId);
            $db->bind(':pId', $primaryId);
            if ($db->single()) {
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
        $supMerged++;
    }
}
echo "Merged {$supMerged} supervisor rows.\n\n";

// 2. PROCESS EXAMINERS TABLE
echo "[2] Processing examiners table...\n";
$db->query("SELECT examiner_id, examiner_name FROM examiners");
$examiners = $db->resultSet();

$visitedExam = [];
$examClusters = [];

for ($i = 0; $i < count($examiners); $i++) {
    if (isset($visitedExam[$i])) continue;
    $e1 = $examiners[$i];
    $t1 = getCoreTokens($e1['examiner_name']);
    $cluster = [$e1];
    
    for ($j = $i + 1; $j < count($examiners); $j++) {
        if (isset($visitedExam[$j])) continue;
        $e2 = $examiners[$j];
        $t2 = getCoreTokens($e2['examiner_name']);
        
        if (isSamePerson($t1, $t2)) {
            $visitedExam[$j] = true;
            $cluster[] = $e2;
        }
    }
    
    if (count($cluster) > 1) {
        $examClusters[] = $cluster;
    }
}

echo "Found " . count($examClusters) . " examiner duplicate clusters.\n";
$examMerged = 0;

foreach ($examClusters as $cluster) {
    usort($cluster, fn($a, $b) => scoreQuality($b['examiner_name']) <=> scoreQuality($a['examiner_name']));
    $primary = $cluster[0];
    $primaryId = $primary['examiner_id'];
    $canonicalName = $primary['examiner_name'];
    
    echo "  Primary: [{$primaryId}] {$canonicalName}\n";
    
    for ($k = 1; $k < count($cluster); $k++) {
        $dup = $cluster[$k];
        $dupId = $dup['examiner_id'];
        $dupName = $dup['examiner_name'];
        
        echo "    <- Merging duplicate: [{$dupId}] {$dupName}\n";
        $allReplacements[$dupName] = $canonicalName;
        
        $db->query("UPDATE viva_records SET internal_examiner_id = :pId WHERE internal_examiner_id = :dupId");
        $db->bind(':pId', $primaryId);
        $db->bind(':dupId', $dupId);
        $db->execute();

        $db->query("UPDATE viva_records SET external_examiner_id = :pId WHERE external_examiner_id = :dupId");
        $db->bind(':pId', $primaryId);
        $db->bind(':dupId', $dupId);
        $db->execute();

        $db->query("SELECT student_id FROM student_examiners WHERE examiner_id = :dupId");
        $db->bind(':dupId', $dupId);
        foreach ($db->resultSet() as $link) {
            $sId = $link['student_id'];
            $db->query("SELECT id FROM student_examiners WHERE student_id = :sId AND examiner_id = :pId");
            $db->bind(':sId', $sId);
            $db->bind(':pId', $primaryId);
            if ($db->single()) {
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
        $examMerged++;
    }
}
echo "Merged {$examMerged} examiner rows.\n\n";

// 3. UPDATE CHAIRPERSON NAMES IN VIVA_RECORDS
echo "[3] Normalizing viva_records chairperson names...\n";
foreach ($allReplacements as $variant => $canonical) {
    $db->query("UPDATE viva_records SET chairperson_name = :canonical WHERE chairperson_name = :variant");
    $db->bind(':canonical', $canonical);
    $db->bind(':variant', $variant);
    $db->execute();
}

echo "\nCOMPLETED STRICT DEDUPLICATION!\n";

