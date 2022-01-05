<?php

$startTime = microtime(true);

#$input = file('./demo.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

enum Directions: string {
    case UP = "UP";
    case DOWN = "DOWN";
    case LEFT = "LEFT";
    case RIGHT = "RIGHT";

    public function turnLeft(): Directions
    {
        switch ($this) {
            case Directions::UP:
                return Directions::LEFT;
            case Directions::DOWN:
                return Directions::RIGHT;
            case Directions::LEFT:
                return Directions::DOWN;
            case Directions::RIGHT:
                return Directions::UP;
        }
    }

    public function turnRight(): Directions
    {
        switch ($this) {
            case Directions::UP:
                return Directions::RIGHT;
            case Directions::DOWN:
                return Directions::LEFT;
            case Directions::LEFT:
                return Directions::UP;
            case Directions::RIGHT:
                return Directions::DOWN;
        }
    }

    public function reverse(): Directions
    {
        switch ($this) {
            case Directions::UP:
                return Directions::DOWN;
            case Directions::DOWN:
                return Directions::UP;
            case Directions::LEFT:
                return Directions::RIGHT;
            case Directions::RIGHT:
                return Directions::LEFT;
        }
    }
}


enum Statuses {
    case CLEAN;
    case WEAKENED;
    case INFECTED;
    case FLAGGED;

    public function change(): Statuses
    {
        switch ($this) {
            case self::CLEAN:
                return Statuses::WEAKENED;
            case self::WEAKENED:
                ++$GLOBALS['newlyInfectedCount'];
                return Statuses::INFECTED;
            case self::INFECTED:
                return Statuses::FLAGGED;
            case self::FLAGGED:
                return Statuses::CLEAN;
        }
    }
}


$map = [];
foreach ($input as $rowNum => $row) {
    foreach (str_split($row) as $colNum => $cell) {
        if ($cell === '#') {
            $map["{$rowNum},{$colNum}"] = Statuses::INFECTED;
        }
    }
}


$currentDirection = Directions::UP;
$currentCol = $currentRow = (int)floor(count($input)/2);
$newlyInfectedCount = 0;

for ($i = 0; $i < 10000000; $i++) {
    if (!isset($map["{$currentRow},{$currentCol}"])) {
        $map["{$currentRow},{$currentCol}"] = Statuses::CLEAN;
    }

    switch ($map["{$currentRow},{$currentCol}"]) {
        case Statuses::CLEAN:
            $currentDirection = $currentDirection->turnLeft();
            break;
        case Statuses::INFECTED:
            $currentDirection = $currentDirection->turnRight();
            break;
        case Statuses::FLAGGED:
            $currentDirection = $currentDirection->reverse();
            break;
    }

    $map["{$currentRow},{$currentCol}"] = $map["{$currentRow},{$currentCol}"]->change();

    switch ($currentDirection) {
        case Directions::UP:
            --$currentRow;
            break;
        case Directions::DOWN:
            ++$currentRow;
            break;
        case Directions::LEFT:
            --$currentCol;
            break;
        case Directions::RIGHT:
            ++$currentCol;
    }
}

echo $newlyInfectedCount;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
