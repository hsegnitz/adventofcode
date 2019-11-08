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

foreach ($patches as $a) {
    foreach ($patches as $b) {
        if ($a === $b) {
            continue;
        }

        if (overlapSize($a, $b) > 0) {
            continue 2;
        }
    }
    echo $a['id'];
    #die();
}


function overlapSize($a, $b)
{
    $overlapX = max(0, min($a['right'],  $b['right'])  - max($a['left'], $b['left']));
    $overlapY = max(0, min($a['bottom'], $b['bottom']) - max($a['top'],  $b['top']));
    return $overlapX * $overlapY;
}
