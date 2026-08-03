<?php
/**
 * Automated script to merge duplicate Examiners and Supervisors into single primary records.
 */

$pdo = new PDO('mysql:host=localhost;dbname=prvts_db;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function normalizeName(string $name): string {
    $clean = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', '', $name);
    $clean = preg_replace('/01\d[\d\s\-]{6,}/', '', $clean);
    $clean = preg_replace('/\b\d+[\)\.]\s*/', '', $clean);
    $titles = [
        'assoc. prof. sr. dr.', 'assoc. prof. dr.', 'prof. madya dr.', 'prof. dato\' dr.',
        'prof. datin dr.', 'prof. dr.', 'assoc. prof.', 'prof. madya', 'prof. dato\'',
        'prof. datin', 'prof.', 'assoc prof', 'prof madya', 'dr.', 'dr', 'ts.', 'ir.',
        'hj.', 'hjh.', 'dato\'', 'datin', 'sr.'
    ];
    $clean = strtolower($clean);
    foreach ($titles as $t) {
        $clean = str_replace($t, '', $clean);
    }
    $clean = preg_replace('/[^a-z0-9\s]/', '', $clean);
    $clean = preg_replace('/\s+/', ' ', $clean);
    return trim($clean);
}

echo "=== STARTING AUTOMATED DEDUPLICATION ===\n\n";

$pdo->beginTransaction();

try {
    // ----------------------------------------------------
    // 1. DEDUPLICATE EXAMINERS
    // ----------------------------------------------------
    echo "--- Deduplicating Examiners ---\n";
    $exStmt = $pdo->query("SELECT e.*, 
        (SELECT COUNT(*) FROM student_examiners se WHERE se.examiner_id = e.examiner_id) AS student_count
        FROM examiners e ORDER BY examiner_id ASC");
    $examiners = $exStmt->fetchAll(PDO::FETCH_ASSOC);

    $exGroups = [];
    foreach ($examiners as $ex) {
        $norm = normalizeName($ex['examiner_name']);
        if ($norm === '') $norm = strtolower(trim($ex['examiner_name']));
        $exGroups[$norm][] = $ex;
    }

    $mergedExCount = 0;
    $deletedExIds = [];

    foreach ($exGroups as $norm => $group) {
        if (count($group) < 2) continue;

        // Rank group members: highest student count first, then non-empty email/inst, lowest ID
        usort($group, function($a, $b) {
            if ($a['student_count'] !== $b['student_count']) {
                return $b['student_count'] <=> $a['student_count'];
            }
            $scoreA = (!empty($a['email']) ? 2 : 0) + (!empty($a['institution']) ? 1 : 0);
            $scoreB = (!empty($b['email']) ? 2 : 0) + (!empty($b['institution']) ? 1 : 0);
            if ($scoreA !== $scoreB) {
                return $scoreB <=> $scoreA;
            }
            return $a['examiner_id'] <=> $b['examiner_id'];
        });

        $winner = $group[0];
        $winnerId = (int)$winner['examiner_id'];
        $duplicates = array_slice($group, 1);

        echo "Group '{$norm}': Primary ID {$winnerId} [{$winner['examiner_name']}]\n";

        // Consolidate email/inst/phone into winner if missing
        $updateFields = [];
        $params = [];
        foreach ($duplicates as $dup) {
            $dupId = (int)$dup['examiner_id'];
            $deletedExIds[] = $dupId;
            echo "  -> Merging Duplicate ID {$dupId} [{$dup['examiner_name']}]\n";

            if (empty($winner['email']) && !empty($dup['email'])) {
                $winner['email'] = $dup['email'];
                $updateFields['email'] = $dup['email'];
            }
            if (empty($winner['institution']) && !empty($dup['institution'])) {
                $winner['institution'] = $dup['institution'];
                $updateFields['institution'] = $dup['institution'];
            }
            if (empty($winner['phone']) && !empty($dup['phone'])) {
                $winner['phone'] = $dup['phone'];
                $updateFields['phone'] = $dup['phone'];
            }

            // Update student_examiners
            $seStmt = $pdo->prepare("SELECT student_id, role, email_date, status, report_date FROM student_examiners WHERE examiner_id = ?");
            $seStmt->execute([$dupId]);
            $seRows = $seStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($seRows as $se) {
                $check = $pdo->prepare("SELECT COUNT(*) FROM student_examiners WHERE student_id = ? AND examiner_id = ?");
                $check->execute([$se['student_id'], $winnerId]);
                if ($check->fetchColumn() == 0) {
                    $upd = $pdo->prepare("UPDATE student_examiners SET examiner_id = ? WHERE student_id = ? AND examiner_id = ?");
                    $upd->execute([$winnerId, $se['student_id'], $dupId]);
                } else {
                    $del = $pdo->prepare("DELETE FROM student_examiners WHERE student_id = ? AND examiner_id = ?");
                    $del->execute([$se['student_id'], $dupId]);
                }
            }

            // Update viva_records references
            $pdo->prepare("UPDATE viva_records SET internal_examiner_id = ? WHERE internal_examiner_id = ?")->execute([$winnerId, $dupId]);
            $pdo->prepare("UPDATE viva_records SET external_examiner_id = ? WHERE external_examiner_id = ?")->execute([$winnerId, $dupId]);
            $pdo->prepare("UPDATE viva_records SET reviva_internal_examiner_id = ? WHERE reviva_internal_examiner_id = ?")->execute([$winnerId, $dupId]);
            $pdo->prepare("UPDATE viva_records SET reviva_external_examiner_id = ? WHERE reviva_external_examiner_id = ?")->execute([$winnerId, $dupId]);

            // Delete duplicate examiner
            $pdo->prepare("DELETE FROM examiners WHERE examiner_id = ?")->execute([$dupId]);
            $mergedExCount++;
        }

        if (!empty($updateFields)) {
            $sets = [];
            foreach ($updateFields as $k => $v) {
                $sets[] = "$k = :$k";
            }
            $updateFields['id'] = $winnerId;
            $pdo->prepare("UPDATE examiners SET " . implode(', ', $sets) . " WHERE examiner_id = :id")->execute($updateFields);
        }
    }
    echo "Total Examiners Merged & Deleted: {$mergedExCount}\n\n";

    // ----------------------------------------------------
    // 2. DEDUPLICATE SUPERVISORS
    // ----------------------------------------------------
    echo "--- Deduplicating Supervisors ---\n";
    $supStmt = $pdo->query("SELECT s.*, 
        (SELECT COUNT(*) FROM student_supervisors ss WHERE ss.supervisor_id = s.supervisor_id) AS student_count
        FROM supervisors s ORDER BY supervisor_id ASC");
    $supervisors = $supStmt->fetchAll(PDO::FETCH_ASSOC);

    $supGroups = [];
    foreach ($supervisors as $sup) {
        $norm = normalizeName($sup['supervisor_name']);
        if ($norm === '') $norm = strtolower(trim($sup['supervisor_name']));
        $supGroups[$norm][] = $sup;
    }

    $mergedSupCount = 0;

    foreach ($supGroups as $norm => $group) {
        if (count($group) < 2) continue;

        usort($group, function($a, $b) {
            if ($a['student_count'] !== $b['student_count']) {
                return $b['student_count'] <=> $a['student_count'];
            }
            $scoreA = (!empty($a['email']) ? 2 : 0) + (!empty($a['department']) ? 1 : 0);
            $scoreB = (!empty($b['email']) ? 2 : 0) + (!empty($b['department']) ? 1 : 0);
            if ($scoreA !== $scoreB) {
                return $scoreB <=> $scoreA;
            }
            return $a['supervisor_id'] <=> $b['supervisor_id'];
        });

        $winner = $group[0];
        $winnerId = (int)$winner['supervisor_id'];
        $duplicates = array_slice($group, 1);

        echo "Group '{$norm}': Primary ID {$winnerId} [{$winner['supervisor_name']}]\n";

        $updateFields = [];
        foreach ($duplicates as $dup) {
            $dupId = (int)$dup['supervisor_id'];
            echo "  -> Merging Duplicate ID {$dupId} [{$dup['supervisor_name']}]\n";

            if (empty($winner['email']) && !empty($dup['email'])) {
                $winner['email'] = $dup['email'];
                $updateFields['email'] = $dup['email'];
            }
            if (empty($winner['department']) && !empty($dup['department'])) {
                $winner['department'] = $dup['department'];
                $updateFields['department'] = $dup['department'];
            }
            if (empty($winner['phone']) && !empty($dup['phone'])) {
                $winner['phone'] = $dup['phone'];
                $updateFields['phone'] = $dup['phone'];
            }

            // Update student_supervisors
            $ssStmt = $pdo->prepare("SELECT student_id, role FROM student_supervisors WHERE supervisor_id = ?");
            $ssStmt->execute([$dupId]);
            $ssRows = $ssStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($ssRows as $ss) {
                $check = $pdo->prepare("SELECT COUNT(*) FROM student_supervisors WHERE student_id = ? AND supervisor_id = ?");
                $check->execute([$ss['student_id'], $winnerId]);
                if ($check->fetchColumn() == 0) {
                    $upd = $pdo->prepare("UPDATE student_supervisors SET supervisor_id = ? WHERE student_id = ? AND supervisor_id = ?");
                    $upd->execute([$winnerId, $ss['student_id'], $dupId]);
                } else {
                    $del = $pdo->prepare("DELETE FROM student_supervisors WHERE student_id = ? AND supervisor_id = ?");
                    $del->execute([$ss['student_id'], $dupId]);
                }
            }

            // Delete duplicate supervisor
            $pdo->prepare("DELETE FROM supervisors WHERE supervisor_id = ?")->execute([$dupId]);
            $mergedSupCount++;
        }

        if (!empty($updateFields)) {
            $sets = [];
            foreach ($updateFields as $k => $v) {
                $sets[] = "$k = :$k";
            }
            $updateFields['id'] = $winnerId;
            $pdo->prepare("UPDATE supervisors SET " . implode(', ', $sets) . " WHERE supervisor_id = :id")->execute($updateFields);
        }
    }
    echo "Total Supervisors Merged & Deleted: {$mergedSupCount}\n\n";

    $pdo->commit();
    echo "=== SUCCESS: AUTOMATED DEDUPLICATION COMPLETED CLEANLY ===\n";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "ERROR during deduplication: " . $e->getMessage() . "\n";
}
