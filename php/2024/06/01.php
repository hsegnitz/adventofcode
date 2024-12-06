<?php

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$map = [];
$currentRow = $currentCol = 0;
foreach ($lines as $line) {
    if (false !== ($found = strpos($line, '^'))) {
        $currentRow = count($map);
        $currentCol = $found;
    }
    $map[] = str_split($line);
}

// N = 0, E = 1, S = 2, W = 3
$directions = [
    0 => [0, -1],
    1 => [1,  0],
    2 => [0,  1],
    3 => [-1, 0],
];
$facing = 0;


$visitedPos = [
    "{$currentCol}x{$currentRow}" => true,
];
while (true) {
    $newCol = $currentCol + $directions[$facing][0];
    $newRow = $currentRow + $directions[$facing][1];

    if (!isset($map[$newRow][$newCol])) {
        break;
    }
    if ($map[$newRow][$newCol] === '#') {
        $facing = ++$facing % 4;
        continue;
    }

    $currentRow = $newRow;
    $currentCol = $newCol;
    $visitedPos["{$currentCol}x{$currentRow}"] = true;
}


echo count($visitedPos), "\n";

echo microtime(true) - $start;
echo "\n";
