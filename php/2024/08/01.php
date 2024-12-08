<?php

use common\ArrayKeyCache;
use common\math;

$start = microtime(true);

require_once '../../common/math.php';
require_once '../../common/ArrayKeyCache.php';

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$nodesByFrequency = $map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}

$maxRows = count($map);
$maxCols = count($map[0]);

foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $cell) {
        if ($cell === '.') {
            continue;
        }
        if (!isset($nodesByFrequency[$cell])) {
            $nodesByFrequency[$cell] = [];
        }
        $nodesByFrequency[$cell][] = [$rowNum, $colNum];
    }
}

#print_r($nodesByFrequency);

function antinode(array $start, array $end): ?array
{
    global $maxRows, $maxCols;
    $delta = math::taxiDelta($start[0], $end[0], $start[1], $end[1]);

    $newRow = $end[0] + $delta[0];
    $newCol = $end[1] + $delta[1];

    if ($newCol < 0 || $newCol >= $maxCols || $newRow < 0 || $newRow >= $maxRows) {
        return null;
    }

    return [$newRow, $newCol];
}


$antinodes = new ArrayKeyCache('x');

foreach ($nodesByFrequency as $frequency => $nodes) {
    foreach ($nodes as $nodeNum => $node) {
        for ($i = $nodeNum+1; $i < count($nodes); $i++) {
            $antinode = antinode($node, $nodes[$i]);
            if ($antinode !== null) {
                $antinodes->store($antinode, true);
            }
            $antinode = antinode($nodes[$i], $node);
            if ($antinode !== null) {
                $antinodes->store($antinode, true);
            }
        }
    }
}

/*
foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $cell) {
        if ($antinodes->has([$rowNum, $colNum])) {
            echo "#";
        } else {
            echo '.';
        }
    }
    echo "\n";
}
*/

echo count($antinodes) . "\n";

echo microtime(true) - $start;
echo "\n";
