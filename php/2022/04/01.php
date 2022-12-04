<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$count1 = $count2 = 0;
foreach ($input as $line) {
    [$a, $b, $x, $y] = preg_split('/[,-]/', $line);
    if (($a <= $x && $b >= $y) || ($a >= $x && $b <= $y)) {
        ++$count1;
    }

    if ((max($b, $y) - min($a, $x) + 1) < (($b - $a) + ($y - $x) + 2)) {
        ++$count2;
    }
}

echo 'Part 1: ', $count1;
echo "\nPart 2: ", $count2;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

