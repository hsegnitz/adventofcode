<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}


function reduce(&$map): int
{
    $directions = [
        [-1, -1],
        [ 0, -1],
        [ 1, -1],
        [ 1,  0],
        [ 1,  1],
        [ 0,  1],
        [-1,  1],
        [-1,  0],
    ];

    $newMap = [];
    $count = 0;
    foreach ($map as $rowNum => $row) {
        foreach ($row as $colNum => $char) {
            $newMap[$rowNum][$colNum] = $char;
            if ($char !== '@') {
                continue;
            }
            $surr = 0;
            foreach ($directions as $direction) {
                $searchRow = $rowNum + $direction[1];
                $searchCol = $colNum + $direction[0];
                if (!isset($map[$searchRow][$searchCol])) {
                    continue;
                }
                if ($map[$searchRow][$searchCol] === '@') {
                    ++$surr;
                }
                if ($surr > 3) {
                    continue 2;
                }
            }
            $newMap[$rowNum][$colNum] = '.';
            ++$count;
        }
    }

    $map = $newMap;
    return $count;
}

$totalCount = 0;

while (($count = reduce($map)) > 0) {
    $totalCount += $count;
}

echo $totalCount, "\n";

echo microtime(true) - $start;
echo "\n";
