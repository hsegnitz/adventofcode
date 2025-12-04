<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}

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

$count = 0;
foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $char) {
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
        ++$count;
    }
}


echo $count, "\n";

echo microtime(true) - $start;
echo "\n";
