<?php

$startTime = microtime(true);

$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;
foreach ($input as $line) {
    $sum += (floor($line/3) - 2);
}

echo $sum;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
