<?php
/**
 * Update prvts_db.sql with canonical names
 */

$sqlFile = 'c:/xampp/htdocs/PRV_Tracking_System/prvts_db.sql';

if (!file_exists($sqlFile)) {
    echo "SQL dump not found.\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);

require_once 'c:/xampp/htdocs/PRV_Tracking_System/database/deduplicate_names.php';

// We can read $mappings from deduplicate_names.php
$replacedCount = 0;

foreach ($mappings as $canonical => $variants) {
    foreach ($variants as $variant) {
        if ($variant === $canonical) continue;
        
        // Exact string replace inside single quotes in SQL file
        $count = 0;
        $sql = str_replace("'" . $variant . "'", "'" . $canonical . "'", $sql, $count);
        $replacedCount += $count;
        
        // Handle escaped quotes if any
        $variantEscaped = str_replace("'", "\\'", $variant);
        $canonicalEscaped = str_replace("'", "\\'", $canonical);
        $sql = str_replace("'" . $variantEscaped . "'", "'" . $canonicalEscaped . "'", $sql, $count);
        $replacedCount += $count;
    }
}

file_put_contents($sqlFile, $sql);
echo "\nUpdated prvts_db.sql: replaced {$replacedCount} instances of duplicate name variants with canonical standard names.\n";

