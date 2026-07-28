<?php
namespace App\Services;

use ZipArchive;
use Exception;

class DocxTemplateEngine
{
    /**
     * Replace placeholders in a .docx file and save or stream output.
     * 
     * @param string $templatePath Path to original .docx file
     * @param array $data Key-value map of placeholders (e.g., ['student_name' => 'John Doe'])
     * @param string|null $outputPath Output path to save file, or null to return content as binary string
     * @return string|bool Binary contents if $outputPath is null, or bool success status if saved to file
     */
    public static function process(string $templatePath, array $data, ?string $outputPath = null): string|bool
    {
        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found: {$templatePath}");
        }

        // Create a temporary working copy of the zip
        $tempZip = sys_get_temp_dir() . '/docx_tpl_' . uniqid() . '.docx';
        if (!copy($templatePath, $tempZip)) {
            throw new Exception("Failed to copy template to temp path.");
        }

        $zip = new ZipArchive();
        if ($zip->open($tempZip) !== true) {
            throw new Exception("Failed to open docx file as ZIP archive.");
        }

        // 1. Read document.xml content
        $xmlContent = $zip->getFromName('word/document.xml');
        if ($xmlContent !== false) {
            $xmlContent = self::replaceVariablesInXml($xmlContent, $data);
            $zip->addFromString('word/document.xml', $xmlContent);
        }

        // 2. Read headers and footers if any exist
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            if (preg_match('/^word\/(header|footer)\d+\.xml$/i', $filename)) {
                $content = $zip->getFromName($filename);
                if ($content !== false) {
                    $content = self::replaceVariablesInXml($content, $data);
                    $zip->addFromString($filename, $content);
                }
            }
        }

        $zip->close();

        // 3. Output handling
        if ($outputPath !== null) {
            $result = copy($tempZip, $outputPath);
            @unlink($tempZip);
            return $result;
        } else {
            $content = file_get_contents($tempZip);
            @unlink($tempZip);
            return $content;
        }
    }

    /**
     * Replaces variable keys in XML content, handling Word's split XML tags inside placeholders.
     */
    private static function replaceVariablesInXml(string $xml, array $data): string
    {
        // Step A: Clean XML tags that split placeholders across Word's internal run tags.
        // Handle {{KEY}} double-curly format (highest priority, process first)
        $xml = preg_replace_callback('/\{\{.*?\}\}/s', function ($matches) {
            return preg_replace('/<[^>]+>/', '', $matches[0]);
        }, $xml);

        // Handle ${KEY} dollar-curly format
        $xml = preg_replace_callback('/\$\{.*?\}/s', function ($matches) {
            return preg_replace('/<[^>]+>/', '', $matches[0]);
        }, $xml);

        // Handle single-curly {KEY} format (UPPERCASE only to avoid false positives on partial XML)
        $xml = preg_replace_callback('/\{[A-Z0-9_]+\}/s', function ($matches) {
            return preg_replace('/<[^>]+>/', '', $matches[0]);
        }, $xml);

        // Handle bracket [KEY] format
        $xml = preg_replace_callback('/\[[A-Z0-9_]+\]/s', function ($matches) {
            return preg_replace('/<[^>]+>/', '', $matches[0]);
        }, $xml);

        // Step B: Build substitution array
        foreach ($data as $key => $value) {
            $valStr = (string)($value ?? '');
            // Convert XML special chars securely
            $escapedVal = htmlspecialchars($valStr, ENT_QUOTES | ENT_XML1, 'UTF-8');
            // Support newline breaks in text
            $escapedVal = str_replace(["\r\n", "\n", "\r"], '</w:t><w:br/><w:t>', $escapedVal);

            // Replace various placeholder syntax formats, most specific first
            $keysToReplace = [
                '{{' . $key . '}}',
                '{{' . strtoupper($key) . '}}',
                '{{' . strtolower($key) . '}}',
                '${' . $key . '}',
                '${' . strtoupper($key) . '}',
                '${' . strtolower($key) . '}',
                '{' . strtoupper($key) . '}',
                '{' . $key . '}',
                '[' . strtoupper($key) . ']',
                '[' . $key . ']'
            ];

            foreach ($keysToReplace as $searchKey) {
                $xml = str_replace($searchKey, $escapedVal, $xml);
            }
        }

        return $xml;
    }
}
