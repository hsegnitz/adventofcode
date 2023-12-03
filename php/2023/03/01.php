<?php

namespace Year2023\Day03;

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

/*$matrix = [];
foreach ($lines as $y => $line) {
    $matrix[$y] = str_split($line);
}*/

$adjacents = [
    [-1, -1],
    [-1,  0],
    [-1,  1],
    [ 0, -1],
    [ 0,  1],
    [ 1, -1],
    [ 1,  0],
    [ 1,  1],
];


$sum = 0;

$maxX = strlen($lines[0]);
$maxY = count($lines);

# find symbol
foreach ($lines as $y => $row) {
    foreach (str_split($row) as $x => $character) {
        if ($character === '.' || is_numeric($character)) {
            continue;
        }

        foreach ($adjacents as $adjacent) {
            $newX = $x + $adjacent[0];
            $newY = $y + $adjacent[1];
            if ($newX < 0 || $newX >= $maxX || $newY < 0 || $newY >= $maxY) {
                continue;
            }
            if (($number = getAndRemoveEntireNumber($lines, $newY, $newX)) !== null) {
#                echo $number, " ";
                $sum += $number;
            }
        }
    }
}

echo $sum, "\n";

# go round symbol and find digit

# go left and right from that digit and find the whole number

# combine to string and cast to int while setting them to dots in the matrix to not doubly count them

# sum up


function getAndRemoveEntireNumber(array &$lines, int $y, int $x): ?int
{
    if (!is_numeric($lines[$y][$x])) {
        return null;
    }

    $startX = $x;
    while ($startX >= 0 && is_numeric($lines[$y][$startX])) {
        $startX--;
    }
    $startX++;  // back one step

    $lineLen = strlen($lines[0]);
    $endX = $x;
    while ($endX < $lineLen && is_numeric($lines[$y][$endX])) {
        $endX++;
    }
    #$endX--;

    $number = substr($lines[$y], $startX, $endX-$startX);

    $lines[$y] = substr($lines[$y], 0, $startX) . implode('', array_fill(0, strlen($number), '.')) . substr($lines[$y], $endX);

    return (int)$number;
}
