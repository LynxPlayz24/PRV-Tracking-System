<?php
namespace App\Helpers;

class NameHelper
{
    /**
     * Get a clean sort key for academic staff names by stripping titles & honorifics.
     */
    public static function getSortKey(string $name): string
    {
        $n = mb_strtoupper(trim($name), 'UTF-8');
        // Standardize quotes and punctuation
        $n = str_replace(["’", "‘", "`", "'", ".", ",", "(", ")", "-"], " ", $n);

        $titles = [
            'ASSOC PROF', 'ASSOC', 'PROFESSOR', 'PROF MADYA', 'PROF DATO', 'PROF DR', 'PROF TPR', 'PROF', 'MADYA',
            'DATO', 'DATUK', 'DATIN', 'DR', 'DOCTOR', 'HJ', 'HAJI', 'HJH', 'HAJAH', 'IR', 'SR', 'TS', 'TPR',
            'PMGR', 'CHAIRPERSON'
        ];

        $tokens = preg_split('/\s+/', $n);
        $filtered = [];
        foreach ($tokens as $t) {
            $tClean = trim($t);
            if (empty($tClean)) continue;
            if (in_array($tClean, $titles)) continue;
            $filtered[] = $tClean;
        }

        return implode(' ', $filtered);
    }

    /**
     * Sort an array of associative arrays by academic name (ignoring titles)
     */
    public static function sortByName(array $list, string $nameKey): array
    {
        usort($list, function ($a, $b) use ($nameKey) {
            $keyA = self::getSortKey($a[$nameKey] ?? '');
            $keyB = self::getSortKey($b[$nameKey] ?? '');
            return strnatcasecmp($keyA, $keyB);
        });

        return $list;
    }
}
