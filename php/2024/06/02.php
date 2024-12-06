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

function walk(int $currentCol, int $currentRow, array $map): array
{
    // N = 0, E = 1, S = 2, W = 3
    $directions = [
        0 => [0, -1],
        1 => [1, 0],
        2 => [0, 1],
        3 => [-1, 0],
    ];
    $facing = 0;

    $visitedPos = [
        "{$currentCol}x{$currentRow}" => true,
    ];
    $visitedPosDirection = [
        "{$currentCol}x{$currentRow}x{$facing}" => true,
    ];
    while (true) {
        $newCol = $currentCol + $directions[$facing][0];
        $newRow = $currentRow + $directions[$facing][1];

        if (!isset($map[$newRow][$newCol])) {
            return $visitedPos;
        }
        if ($map[$newRow][$newCol] === '#') {
            $facing = ++$facing % 4;
            continue;
        }

        $currentRow = $newRow;
        $currentCol = $newCol;
        if (isset($visitedPosDirection["{$currentCol}x{$currentRow}x{$facing}"])) {
            throw new \Exception('loop', 42);
        }
        $visitedPos["{$currentCol}x{$currentRow}"] = true;
        $visitedPosDirection["{$currentCol}x{$currentRow}x{$facing}"] = true;
    }
}

$visitedPos = walk($currentCol, $currentRow, $map);

// we use just the visitedPos for candidates of new obstacles

$loopPos = [];

//not using the start point
array_shift($visitedPos);

foreach (array_keys($visitedPos) as $coords) {
    [$obstacleCol, $obstacleRow] = explode('x', $coords);
    $newMap = $map;
    $newMap[$obstacleRow][$obstacleCol] = '#';
    try {
        walk($currentCol, $currentRow, $newMap);
    } catch (\Exception $e) {
        if ($e->getCode() === 42) {
            $loopPos[] = $coords;
        }
    }
}

echo count($loopPos), "\n";

echo microtime(true) - $start;
echo "\n";