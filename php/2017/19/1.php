<?php

$startTime = microtime(true);

#$input = file_get_contents('./demo.txt');
$input = file_get_contents('./in.txt');

$input = explode("\n", $input);
$map = [];
foreach ($input as $row) {
    $map[] = str_split($row);
}

enum Directions: string {
    case UP = "UP";
    case DOWN = "DOWN";
    case LEFT = "LEFT";
    case RIGHT = "RIGHT";
}

# find start
$currentRow = 0;
foreach ($map[$currentRow] as $colNum => $cell) {
    if ($cell === '|') {
        $currentCol = $colNum;
    }
}

function walk(array $map, int &$currentCol, int &$currentRow, Directions $direction, array &$foundLetters, int &$steps): ?Directions
{
    $cell = '';
    while ($cell !== '+' && isset($map[$currentRow][$currentCol])) {
        switch ($direction) {
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
                break;
        }

        if (!isset($map[$currentRow][$currentCol]) || $map[$currentRow][$currentCol] === ' ') {
            return null;
        }

        $steps++;

        $cell = $map[$currentRow][$currentCol];
        if (preg_match('/[A-Z]/', $cell)) {
            $foundLetters[] = $cell;
        }
    }

    switch ($direction) {
        case Directions::UP:
        case Directions::DOWN:
            if (isset($map[$currentRow][$currentCol-1]) && $map[$currentRow][$currentCol-1] !== ' ') {
                return Directions::LEFT;
            }
            return Directions::RIGHT;
        case Directions::LEFT:
        case Directions::RIGHT:
        if (isset($map[$currentRow-1][$currentCol]) && $map[$currentRow-1][$currentCol] !== ' ') {
            return Directions::UP;
        }
        return Directions::DOWN;
    }

    return null;
}


$direction = Directions::DOWN;
$foundLetters = [];
$steps = 0;

while (null !== ($direction = walk($map, $currentCol, $currentRow, $direction, $foundLetters, $steps))) {
    echo $direction->value, "\n";
}

echo $steps+1, "\n";
echo implode('', $foundLetters);

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


