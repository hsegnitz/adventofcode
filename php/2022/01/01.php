<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$list = explode("\n\n", $input);

$sums = [];

foreach ($list as $elf => $sticks) {
    $stickList = explode("\n", $sticks);
    $sums[$elf] = array_sum($stickList);
}

echo "part 1: ", max($sums);

rsort ($sums);

$first = array_slice($sums, 0, 3);

echo "\npart 2: ", array_sum($first);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

