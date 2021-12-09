<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

$map = [];
foreach ($input as $row) {
    $map[] = str_split(trim($row));
}


$lowPoints = [];
foreach ($map as $y => $row) {
    foreach ($row as $x => $cell) {
        $adjacent = [];
        if (isset($map[$y-1][$x])) {
            $adjacent[] = $map[$y-1][$x];
        }
        if (isset($row[$x-1])) {
            $adjacent[] = $row[$x-1];
        }
        if (isset($row[$x+1])) {
            $adjacent[] = $row[$x+1];
        }
        if (isset($map[$y+1][$x])) {
            $adjacent[] = $map[$y+1][$x];
        }

        $allLower = true;
        foreach ($adjacent as $adj) {
            if ($cell >= $adj) {
                $allLower = false;
                break;
            }
        }

        if ($allLower) {
            $lowPoints[] = $cell;
        }
    }
}


echo array_sum($lowPoints) + count($lowPoints);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


