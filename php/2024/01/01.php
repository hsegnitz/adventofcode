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

sort($left);
sort($right);

$sum = 0;
foreach ($left as $index => $num) {
    $lineDiff = abs($num - $right[$index]);
    $sum += $lineDiff;
}

echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";
