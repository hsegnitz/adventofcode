<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$count = 0;
foreach ($input as $line) {
    [$a, $b, $x, $y] = preg_split('/[,-]/', $line);
    if ($a <= $x && $b >= $y) {
        ++$count;
        continue;
    }
    if ($a >= $x && $b <= $y) {
        ++$count;
    }
}

echo 'Part 1: ', $count;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

