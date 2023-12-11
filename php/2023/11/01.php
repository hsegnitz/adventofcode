<?php

namespace Year2023\Day11;

use common\math;

require_once __DIR__ . '/../../common/math.php';

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}

$galaxies = [];
foreach ($map as $y => $row) {
    foreach ($row as $x => $cell) {
        if ($cell === '#') {
            $galaxies[] = ['x' => $x, 'y' => $y];
        }
    }
}

#print_r($galaxies);
$emptyCols = array_values(array_diff(range(0, count($map[0])-1), array_unique(array_column($galaxies, 'x'))));
$emptyRows = array_values(array_diff(range(0, count($map)-1),    array_unique(array_column($galaxies, 'y'))));

#print_r($emptyCols);
#print_r($emptyRows);

function growUniverse(array $galaxies, array $emptyCols, array $emptyRows, int $by = 1): array
{
    $universe = $galaxies;
    foreach ($galaxies as $galNum => &$galaxy) {
        $compUniverse = $universe[$galNum];
        foreach ($emptyRows as $emptyRow) {
            if ($compUniverse['y'] > $emptyRow) {
                $galaxy['y'] += $by;
            }
        }
        foreach ($emptyCols as $emptyCol) {
            if ($compUniverse['x'] > $emptyCol) {
                $galaxy['x'] += $by;
            }
        }
    }

    return $galaxies;
}

$galaxiesPart1 = growUniverse($galaxies, $emptyCols, $emptyRows);
$galaxiesPart2 = growUniverse($galaxies, $emptyCols, $emptyRows, 999999);

#print_r($galaxies);

function getDistances(array $galaxies): array
{
    $distances = [];
    foreach ($galaxies as $galNum => $galaxy) {
        for ($i = $galNum + 1, $max = count($galaxies); $i < $max; $i++) {
            $gal2 = $galaxies[$i];
            $distances[$galNum . ':' . $i] = math::taxiDistance($galaxy['x'], $gal2['x'], $galaxy['y'], $gal2['y']);
        }
    }
    return $distances;
}

$distancesPart1 = getDistances($galaxiesPart1);
$distancesPart2 = getDistances($galaxiesPart2);

echo "part 1: ";
echo array_sum($distancesPart1);
echo "\n";

echo "part 2: ";
echo array_sum($distancesPart2);
echo "\n";


echo microtime(true) - $start;
echo "\n";

