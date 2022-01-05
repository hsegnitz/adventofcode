<?php

$startTime = microtime(true);

#$input = file('./demo.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$infectedPoints = [];
foreach ($input as $rowNum => $row) {
    foreach (str_split($row) as $colNum => $cell) {
        if ($cell === '#') {
            $infectedPoints["{$rowNum},{$colNum}"] = true;
        }
    }
}

enum Directions: string {
    case UP = "UP";
    case DOWN = "DOWN";
    case LEFT = "LEFT";
    case RIGHT = "RIGHT";
}

$currentDirection = Directions::UP;
$currentCol = $currentRow = (int)floor(count($input)/2);
$newlyInfectedPoints = [];
$newlyInfectedCount = 0;

for ($i = 0; $i < 10000; $i++) {
    if (isset($infectedPoints["{$currentRow},{$currentCol}"])) {
        unset ($infectedPoints["{$currentRow},{$currentCol}"]);
        switch ($currentDirection) {
            case Directions::UP:
                $currentDirection = Directions::RIGHT;
                ++$currentCol;
                break;
            case Directions::DOWN:
                $currentDirection = Directions::LEFT;
                --$currentCol;
                break;
            case Directions::LEFT:
                $currentDirection = Directions::UP;
                --$currentRow;
                break;
            case Directions::RIGHT:
                $currentDirection = Directions::DOWN;
                ++$currentRow;
                break;
        }
    } else {
        $newlyInfectedPoints["{$currentRow},{$currentCol}"] = true;
        $newlyInfectedCount++;
        $infectedPoints["{$currentRow},{$currentCol}"] = true;
        switch ($currentDirection) {
            case Directions::UP:
                $currentDirection = Directions::LEFT;
                --$currentCol;
                break;
            case Directions::DOWN:
                $currentDirection = Directions::RIGHT;
                ++$currentCol;
                break;
            case Directions::LEFT:
                $currentDirection = Directions::DOWN;
                ++$currentRow;
                break;
            case Directions::RIGHT:
                $currentDirection = Directions::UP;
                --$currentRow;
                break;
        }
    }
}


#echo count($newlyInfectedPoints);
echo $newlyInfectedCount;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
