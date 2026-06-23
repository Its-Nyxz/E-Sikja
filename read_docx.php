<?php

function searchInDocx($docxPath, $label) {
    if (!file_exists($docxPath)) {
        return "File not found: $docxPath\n";
    }

    $zip = new ZipArchive();
    if ($zip->open($docxPath) !== TRUE) {
        return "Failed to open $docxPath\n";
    }

    $xmlContent = $zip->getFromName('word/document.xml');
    $zip->close();

    if (!$xmlContent) {
        return "Failed to read XML for $docxPath\n";
    }

    // Strip XML tags to get plain text
    $plainText = strip_tags($xmlContent);
    
    $out = "=== Search in: $label ($docxPath) ===\n";
    $out .= "Total text length: " . strlen($plainText) . " chars\n\n";

    $keywords = ['blackbox', 'black box', 'pengujian', 'skenario', 'uji'];
    foreach ($keywords as $keyword) {
        $lastPos = 0;
        $count = 0;
        while (($pos = stripos($plainText, $keyword, $lastPos)) !== false) {
            $count++;
            $start = max(0, $pos - 100);
            $length = 200;
            $snippet = substr($plainText, $start, $length);
            $out .= "Match $count for '$keyword' at position $pos:\n";
            $out .= "[...] " . str_replace("\n", " ", trim($snippet)) . " [...]\n\n";
            $lastPos = $pos + strlen($keyword);
            if ($count >= 10) {
                $out .= "  (Showed first 10 matches)\n\n";
                break;
            }
        }
        if ($count === 0) {
            $out .= "No matches for '$keyword'\n\n";
        }
    }
    return $out;
}

$out1 = searchInDocx("d:\\File's Niko\\Kuliah\\PKL\\Laporan Magang Nikolas Pramuputro 2021061011 revisi.docx", "Revisi");
$out2 = searchInDocx("d:\\File's Niko\\Kuliah\\PKL\\Laporan Magang Nikolas Pramuputro 2021061011.docx", "Original");

file_put_contents("d:\\File's Niko\\Kuliah\\E-sikja\\search_results.txt", $out1 . "\n\n" . $out2);
echo "Search completed. Results in search_results.txt\n";
