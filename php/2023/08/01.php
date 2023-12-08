<?php

namespace Year2023\Day08;

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$rl = str_split(array_shift($lines));
array_shift($lines);

$map = [];
foreach ($lines as $line) {
    if (!preg_match('/(\w+)\s=\s\((\w+),\s(\w+)\)/', $line, $out)) {
        throw new \Exception('no match: ', $line);
    }
    [, $a, $b, $c] = $out;
    $map[$a] = [$b, $c];
}

$current = 'AAA';
$stopAt = 'ZZZ';

$steps = 0;
while ($current !== $stopAt) {
    $rightOrLeft = $rl[$steps % count($rl)];
    if ($rightOrLeft === 'L') {
        $current = $map[$current][0];
    } else {
        $current = $map[$current][1];
    }
    ++$steps;
}


echo "\n", $steps, "\n";

echo microtime(true) - $start;
echo "\n";

