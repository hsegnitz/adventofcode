<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$positions = explode(',', $input);
array_walk($positions, static function (&$value) { $value = (int)$value; });

$min = min($positions);
$max = max($positions);

$bestPos = -1;
$bestFuel = PHP_INT_MAX;
for ($i = $min; $i <= $max; $i++) {
    $fuelSum = 0;
    foreach ($positions as $pos) {
        $fuelSum += abs($i - $pos);
    }

    if ($bestFuel > $fuelSum) {
        $bestFuel = $fuelSum;
        $bestPos = $i;
    }
}

echo 'position: ', $bestPos, '; spentFuel: ', $bestFuel;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


