<?php

$raw = file('in.txt');
$patches = [];

foreach ($raw as $rawRow) {
    $out = [];
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $rawRow, $out);

    $patches[] = [
        'id'     => $out[1],
        'left'   => $out[2],
        'top'    => $out[3],
        'width'  => $out[4],
        'height' => $out[5],
        'right'  => $out[2] + $out[4],
        'bottom' => $out[3] + $out[5],
    ];
}

$heatmap = [];
$counter = 0;
foreach ($patches as $patch) {
    $heatmap = bringTheHeat($heatmap, $patch);
}

echo $counter;



function bringTheHeat($map, $patch)
{
    for ($x = $patch['left']; $x < $patch['right']; $x++) {
        if (!isset($map[$x])) {
            $map[$x] = [];
        }

        for ($y = $patch['top']; $y < $patch['bottom']; $y++) {
            if (!isset($map[$x][$y])) {
                $map[$x][$y] = 0;
            } elseif (1 === $map[$x][$y]) {
                ++$GLOBALS['counter'];
            }
            ++$map[$x][$y];
        }
    }

    return $map;
}

