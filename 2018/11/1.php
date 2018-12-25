<?php

function calcval($x, $y)
{
    $input = 1308;

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
for ($x = 1; $x <= 297; $x++) {
    for ($y = 1; $y <= 297; $y++) {
        $sum = $grid[$x][$y]   + $grid[$x+1][$y]   + $grid[$x+2][$y]
            +  $grid[$x][$y+1] + $grid[$x+1][$y+1] + $grid[$x+2][$y+1]
            +  $grid[$x][$y+2] + $grid[$x+1][$y+2] + $grid[$x+2][$y+2];
        if ($sum > $max) {
            $max = $sum;
            $maxX = $x;
            $maxY = $y;
        }
    }
}

echo $max, ' @ ', $maxX, ',', $maxY;
