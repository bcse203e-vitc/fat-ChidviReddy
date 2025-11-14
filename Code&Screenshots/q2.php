<?php
function normalizeText($fileName, $mode) {
    if (!file_exists($fileName)) {
        echo "Error: File not found.\n";
        return 0;
    }
    $lines = file($fileName);
    $correctedLines = [];
    $punctuationLines = [];
    $whitespaceCorrections = 0;
    foreach ($lines as $lineNumber => $line) {
        $line = preg_replace('/[ \t]+/', ' ', $line, -1, $count1);
        $whitespaceCorrections += $count1;
        $trimmed = trim($line);
        if ($trimmed !== $line) {
            $whitespaceCorrections++;
        }
        $line = $trimmed;

        if ($line !== "" && preg_match('/^[[:punct:]]+$/', $line)) {
            $punctuationLines[] = "Line " . ($lineNumber + 1) . ": \"$line\"";
        }

        $correctedLines[] = $line;
    }

    if ($mode === "compress") {
        $final = [];
        $previousBlank = false;

        foreach ($correctedLines as $line) {
            if ($line === "") {
                if (!$previousBlank) {
                    $final[] = "";
                }
                $previousBlank = true;
            } else {
                $final[] = $line;
                $previousBlank = false;
            }
        }
    } elseif ($mode === "expand") {
        $final = [];
        foreach ($correctedLines as $line) {
            $final[] = $line;
            $final[] = "";
        }
    } else {
        echo "Unknown mode.\n";
        $final = $correctedLines;
    }

    file_put_contents($fileName, implode("\n", $final));

    if (!empty($punctuationLines)) {
        echo "Punctuation-only lines:\n";
        foreach ($punctuationLines as $p) echo $p . "<br>";
    }

    return $whitespaceCorrections;
}

$corrections = normalizeText("demo.txt", "compress");

echo "\nCorrections: $corrections <br><br>";
echo "\nFinal File Output <br>";
echo file_get_contents("demo.txt");

?>
