<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$left = $right = [];
foreach ($lines as $line) {
    $split = explode('   ', $line);
    $left[] = $split[0];
    $right[] = $split[1];
}

$sum = 0;
$arrayCounts = array_count_values($right);
foreach ($left as $num) {
    $score = $num * ($arrayCounts[$num] ?? 0);
    $sum += $score;
}

echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";
