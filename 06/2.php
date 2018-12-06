<?php

$input = file('in.txt');
//$input = file('small.txt');

$size = 500;
//$size = 10;

$coordinates = [];
foreach ($input as $row) {
    $split = explode(',', $row);
    $coordinates[] = [
        'x' => (int)$split[0],
        'y' => (int)$split[1],
    ];
}

$safeCount = 0;
for ($x = 0; $x < $size; $x++) {
    for ($y = 0; $y < $size; $y++) {
        $distances = [];
        foreach ($coordinates as $id => $touple) {
            $distances[$id] = taxiDistance($x, $y, $touple['x'], $touple['y']);
        }
        if (array_sum($distances) < 10000) {
            ++$safeCount;
        }
     }
}

echo $safeCount;


function taxiDistance($leftA, $topA, $leftB, $topB)
{
    return abs($leftA - $leftB) + abs($topA - $topB);
}
