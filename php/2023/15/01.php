<?php

namespace Year2023\Day15;

$start = microtime(true);

#$in = file_get_contents('example.txt');
$in = file_get_contents('input.txt');

$commands = explode(",", $in);

$boxes = array_fill(0, 256, []);

$part1Sum = 0;
foreach ($commands as $command) {
    $part1Sum += hash($command);

    if (preg_match('/(\w+)([=-])(\d*)/', $command, $out)) {
        [,$label, $operation, $focalLength] = $out;
    } else {
        die('no match');
    }

    $boxNumber = hash($label);

    if ($operation === '-') {
        if (isset($boxes[$boxNumber][$label])) {
            unset($boxes[$boxNumber][$label]);
        }
    } elseif ($operation === '=') {
        $boxes[$boxNumber][$label] = $focalLength;
    }
}

$part2Sum = 0;
foreach ($boxes as $boxNum => $box) {
    foreach (array_values($box) as $lensNum => $focalLength) {
        $part2Sum += ($boxNum+1) * ($lensNum+1) * $focalLength;
    }
}





echo "\n", $part1Sum, "\n";
echo "\n", $part2Sum, "\n";


echo microtime(true) - $start;
echo "\n";


function hash(string $command): int
{
    $val = 0;
    for ($i = 0, $iMax = strlen($command); $i < $iMax; $i++) {
        $val += ord($command[$i]);
        $val *= 17;
        $val %= 256;
    }

    return $val;
}

