<?php

$start = microtime(true);

#$input = file_get_contents('example2.txt');
$input = file_get_contents('input2.txt');

$sum = 0;

$map = [
    'x' => 0,
    'A' => 0,
    'B' => 1,
    'C' => 3,
    'D' => 5,
];

$pairs = str_split($input, 2);
foreach ($pairs as $pair) {
    [$a, $b] = str_split($pair, 1);
    if ($a !== 'x' && $b !== 'x') {
        $sum += 2;
    }
    $sum += $map[$a];
    $sum += $map[$b];
}

echo $sum;

echo "\n";
echo microtime(true) - $start;
echo "\n";
