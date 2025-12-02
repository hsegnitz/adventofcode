<?php

$start = microtime(true);

#$input = file_get_contents('example3.txt');
$input = file_get_contents('input3.txt');

$sum = 0;

$map = [
    'x' => 0,
    'A' => 0,
    'B' => 1,
    'C' => 3,
    'D' => 5,
];

$pairs = str_split($input, 3);
foreach ($pairs as $pair) {
    [$a, $b, $c] = str_split($pair, 1);
    switch (substr_count($pair, 'x')) {
        case 0:
            $sum += 6;
            break;
        case 1:
            $sum += 2;
            break;
    }
    $sum += $map[$a];
    $sum += $map[$b];
    $sum += $map[$c];
}

echo $sum;

echo "\n";
echo microtime(true) - $start;
echo "\n";
