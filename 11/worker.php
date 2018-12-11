<?php

function calcval($x, $y)
{
    $input = 1308;
    //$input = 18;

    $rackId = $x + 10;
    $value = $rackId * $y;
    $value += $input;
    $value *= $rackId;
    if ($value < 100) {
        $value = 0;
    } else {
        $value = substr((string)$value, -3, 1);
    }

    return $value - 5;
}

function sum($grid, $x, $y, $size)
{
    $sum = 0;
    for ($cx = $x; $cx < $x + $size; $cx++) {
        for ($cy = $y; $cy < $y + $size; $cy++) {
            $sum += $grid[$cx][$cy];
        }
    }
    return $sum;
}

$grid = [];

for ($x = 1; $x <= 300; $x++) {
    $grid[$x] = [];
    for ($y = 1; $y <= 300; $y++) {
        $value = calcval($x, $y);
        $grid[$x][$y] = $value;
    }
}

$max = -PHP_INT_MAX;
$maxX = 0;
$maxY = 0;
$maxZ = 0;

$x = $argv[1];
for ($y = 1; $y <= 300; $y++) {
    $rightZ = min (301-$x, 301-$y);
//    echo $x, 'x', $y, 'x', $rightZ, '  -  ';
//    echo $max, ' @ ', $maxX, ',', $maxY, ',', $maxZ, "\n";
    for ($z = 1; $z < $rightZ; $z++) {
        $sum = sum($grid, $x, $y, $z);
        if ($sum > $max) {
            $max = $sum;
            $maxX = $x;
            $maxY = $y;
            $maxZ = $z;
        }
    }
}

echo $max, ' @ ', $maxX, ',', $maxY, ',', $maxZ;
