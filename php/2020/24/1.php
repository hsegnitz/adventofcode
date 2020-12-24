<?php

$startTime = microtime(true);

// thank you so much red blob games! https://www.redblobgames.com/grids/hexagons/#coordinates

// input parsing

$paths = [];
foreach (file(__DIR__ . '/in.txt') as $row) {
    $rawSteps = str_split(trim($row));
    $steps = [];
    while(count($rawSteps)) {
        $step = array_shift($rawSteps);
        if ($step === 's' || $step === 'n') {
            $step .= array_shift($rawSteps);
        }
        $steps[] = $step;
    }
    $paths[] = $steps;
}

#print_r($paths);

$grid = [];


// true === black


function printHexGrid($grid)
{
    $minY = min(0, min(array_keys($grid))) - 1;
    $maxY = max(0, max(array_keys($grid))) + 1;
    $minX = 0;
    $maxX = 0;
    foreach ($grid as $row) {
        $minX = min(min(array_keys($row)), $minX);
        $maxX = max(max(array_keys($row)), $maxX);
    }
    $minX--; $maxX++;

    for ($y = $minY; $y <= $maxY; $y++) {
        echo str_pad($y, 4, " ", STR_PAD_LEFT), "  ";
        if ($y % 2 === 0) {
            echo " ";
        }
        for ($x = $minX; $x <= $maxX; $x++) {
            echo (isset($grid[$y][$x]) && true === $grid[$y][$x]) ? 'O ' : '. ';
        }
        echo "\n";
    }
}

function flipTile(array $grid, array $path): array
{
    $posY = 0;
    $posX = 0;
    foreach ($path as $step) {
        switch($step) {
            case 'e':
                $posX--;
                break;
            case 'w':
                $posX++;
                break;
            case 'ne':
                $posX += ($posY % 2 === 0) ? -1 : 0;
                $posY--;
                break;
            case 'nw':
                $posX += ($posY % 2 === 0) ? 0 : 1;
                $posY--;
                break;
            case 'se':
                $posX += ($posY % 2 === 0) ? -1 : 0;
                $posY++;
                break;
            case 'sw':
                $posX += ($posY % 2 === 0) ? 0 : 1;
                $posY++;
                break;
            default:
                throw new RuntimeException('WTF is this shit?!');
        }
    }

    if (!isset($grid[$posY])) {
        $grid[$posY] = [];
    }

    if (!isset($grid[$posY][$posX])) {
        $grid[$posY][$posX] = false;
    }

    $grid[$posY][$posX] = !$grid[$posY][$posX];

    return $grid;
}

function countTruth(array $grid): int
{
    $count = 0;
    foreach ($grid as $row) {
        foreach ($row as $tile) {
            if ($tile === true) {
                ++$count;
            }
        }
    }
    return $count;
}



foreach ($paths as $path) {
    $grid = flipTile($grid, $path);
}



printHexGrid($grid);

echo "Part 1, Black Tiles: ", countTruth($grid);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
