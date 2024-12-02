<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$countPart1 = $countPart2 = 0;
foreach ($lines as $line) {
    $split = explode(' ', $line);
    #echo $line, ': ';
    if (isSafe($split)) {
        ++$countPart1;
     #   echo "safe 1  ";
    }
    if (isSafePart2($split)) {
        ++$countPart2;
      #  echo "safe 2  ";
    }
    #echo "\n";
}


function isSafe(array $line): bool {
    $ordered = $reverse = $line;
    sort($ordered);
    rsort($reverse);

    if ($ordered !== $line && $reverse !== $line) {
        return false;
    }

    for ($i = 0; $i < count($line)-1; $i++) {
        $diff = abs($line[$i] - $line[$i+1]);
        if ($diff > 3 || $diff < 1) {
            return false;
        }
    }
    return true;
}

function isSafePart2(array $line): bool {
    if (isSafe($line)) {
        return true;
    }
    for ($i = 0; $i < count($line); $i++) {
        $temp = $line;
        unset($temp[$i]);
        if (isSafe(array_values($temp))) {
            return true;
        }
    }
    return false;
}


echo $countPart1, "\n";
echo $countPart2, "\n";

echo microtime(true) - $start;
echo "\n";
