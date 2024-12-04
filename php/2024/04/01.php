<?php

$start = microtime(true);


#$lines = file('simple.txt', FILE_IGNORE_NEW_LINES);
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

$search = ['X', 'M', 'A', 'S'];

$count = 0;
foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $char) {
        foreach ($directions as $direction) {
            foreach ($search as $distance => $searchChar) {
                $searchRow = $rowNum + ($distance * $direction[1]);
                $searchCol = $colNum + ($distance * $direction[0]);
                if (!isset($map[$searchRow][$searchCol]) || $map[$searchRow][$searchCol] !== $searchChar) {
                    continue 2;
                }
                #echo "found $searchChar at $searchRow x $searchCol\n";
            }
            ++$count;
        }
    }
}




echo $count, "\n";

echo microtime(true) - $start;
echo "\n";
