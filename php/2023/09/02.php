<?php

namespace Year2023\Day08;

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$seqs = [];
foreach ($lines as $line) {
    $seqs[] = explode(" ", $line);
}



function findPreviousInSequence (array $in): int
{
    $dims[] = $newLine = $in;
    while (!isAllZeros($newLine)) {
        $dims[] = $newLine = getNextRow($newLine);
    }

    for ($i = count($dims)-1; $i > 0; $i--) {
        $dims[$i-1][] = $dims[$i-1][array_key_last($dims[$i-1])] + $dims[$i][array_key_last($dims[$i])];   // part1
        array_unshift($dims[$i-1], $dims[$i-1][0] - $dims[$i][0]);    // part2
    }

   # print_r($dims);

    return $dims[0][0];
}

function getNextRow(array $in): array
{
    $next = [];
    for ($i = 0, $count = count($in); $i < $count-1; $i++) {
        $next[] = $in[$i+1] - $in[$i];
    }
    return $next;
}

function isAllZeros(array $in): bool
{
    foreach ($in as $i) {
        if ($i !== 0) {
            return false;
        }
    }
    return true;
}

$sum = 0;
foreach ($seqs as $seq) {
    $sum += findPreviousInSequence($seq);
}

echo "\n", $sum, "\n";

echo microtime(true) - $start;
echo "\n";

