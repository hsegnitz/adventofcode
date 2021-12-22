<?php

$startTime = microtime(true);

#$input = file('./example0.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example1.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example2.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$matrix = [];

foreach ($input as $line) {
    if (!preg_match('/(on|off) x=([\-0-9]+)\.\.([\-0-9]+),y=([\-0-9]+)\.\.([\-0-9]+),z=([\-0-9]+)\.\.([\-0-9]+)/', $line, $out)) {
        throw new RuntimeException('<NELSON>HAAHAA!</NELSON>');
    }
    [,$onOff, $xFrom, $xTo, $yFrom, $yTo, $zFrom, $zTo] = $out;

    $xFrom = max($xFrom, -50);
    $xTo   = min($xTo,    50);
    $yFrom = max($yFrom, -50);
    $yTo   = min($yTo,    50);
    $zFrom = max($zFrom, -50);
    $zTo   = min($zTo,    50);

    for ($x = $xFrom; $x <= $xTo; $x++) {
        for ($y = $yFrom; $y <= $yTo; $y++) {
            for ($z = $zFrom; $z <= $zTo; $z++) {
                if ($onOff === 'on') {
                    $matrix["{$x},{$y},{$z}"] = true;
                } else {
                    unset ($matrix["{$x},{$y},{$z}"]);
                }
            }
        }
    }
}

echo count($matrix);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

