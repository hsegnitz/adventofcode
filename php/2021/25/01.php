<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$map = [];
foreach ($input as $line) {
    $map[] = str_split($line);
}

function mapToString(array $map): string
{
    $str = '';
    foreach ($map as $line) {
        $str .= implode('', $line) . "\n";
    }
    return $str;
}

function move(array $map): array
{
    $mapWidth  = count($map[0]);
    $mapHeight = count($map);
    $newMapEast = [];
    foreach ($map as $rowNum => $row) {
        for ($i = 0; $i < $mapWidth; $i++) {
            $cell = $row[$i];
            if ($cell === '>') {
                $destination = ($i +1) % $mapWidth;
                if ($row[$destination] === '.') {
                    $newMapEast[$rowNum][$i] = '.';
                    $newMapEast[$rowNum][$destination] = '>';
                    $i++;
                } else {
                    $newMapEast[$rowNum][$i] = '>';
                }
            } else {
                $newMapEast[$rowNum][$i] = $cell;
            }
        }
    }

    $newMapSouth = [];
    for ($colNum = 0; $colNum < $mapWidth; $colNum++) {
        for ($rowNum = 0; $rowNum < $mapHeight; $rowNum++) {
            $cell = $newMapEast[$rowNum][$colNum];
            if ($cell === 'v') {
                $destination = ($rowNum+1) % $mapHeight;
                if ($newMapEast[$destination][$colNum] === '.') {
                    $newMapSouth[$rowNum][$colNum] = '.';
                    $newMapSouth[$destination][$colNum] = 'v';
                    $rowNum++;
                } else {
                    $newMapSouth[$rowNum][$colNum] = 'v';
                }
            } else {
                $newMapSouth[$rowNum][$colNum] = $cell;
            }
        }
    }

    return $newMapSouth;
}

$step = 0;
$states = [];
$mapString = mapToString($map);
while (!isset($states[$mapString])) {
    $step++;
    $states[$mapString] = true;
    $map = move($map);
    $mapString = mapToString($map);

   # echo $step, "\n", $mapString, "\n\n";
}

echo $step;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

