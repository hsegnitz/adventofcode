<?php

$startTime = microtime(true);

$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

function calcFuel(int $mass): int
{
    $fuel = (floor($mass/3) - 2);
    return max($fuel, 0);
}

$sum = 0;
foreach ($input as $line) {
    $temp = $line;
    do {
        $temp = calcFuel($temp);
        $sum += $temp;
    } while ($temp > 0);
}

echo $sum;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
