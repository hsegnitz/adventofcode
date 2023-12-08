<?php

namespace Year2023\Day08;

use common\math;

$start = microtime(true);

require_once '../../common/math.php';


#$lines = file('example3.txt', FILE_IGNORE_NEW_LINES);
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

$currentPositions = [];

foreach (array_keys($map) as $mk) {
    if ($mk[2] === 'A') {
        $currentPositions[] = $mk;
    }
}


function stepsToZ($map, $rl, $start): int {
    $steps = 0;
    $current = $start;
    while ($current[2] !== 'Z') {
        $rightOrLeft = $rl[$steps % count($rl)];
        if ($rightOrLeft === 'L') {
            $current = $map[$current][0];
        } else {
            $current = $map[$current][1];
        }
        ++$steps;
    }
    return $steps;
}

$stepsToZ = [];
foreach ($currentPositions as $current) {
    $stepsToZ[] = stepsToZ($map, $rl, $current);
}



echo "\n", math::leastCommonMultiple(...$stepsToZ), "\n";

echo microtime(true) - $start;
echo "\n";

