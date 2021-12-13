<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

[$rawCoords, $rawFolds] = explode("\n\n", $input);

$rawCoords = explode("\n", $rawCoords);
$rawFolds  = explode("\n", $rawFolds);

$coords = [];
foreach ($rawCoords as $rawCoord) {
    [$x, $y] = explode(',', $rawCoord);
    $coords[$rawCoord] = ['x' => $x, 'y' => $y];
}

$folds = [];
foreach ($rawFolds as $rawFold) {
    preg_match('/fold along (\w)=(\d+)/', $rawFold, $out);
    $folds[] = [
        'axis'     => $out[1],
        'position' => $out[2],
    ];
}


function fold(array $coords, string $axis, int $position): array
{
    $newCoords = [];
    foreach ($coords as $key => $coord) {
        if ($coord[$axis] < $position) {
            $newCoords[$key] = $coord;
            continue;
        }

        $coord[$axis] = abs($position - ($coord[$axis] - $position));
        $newCoords["{$coord['x']},{$coord['y']}"] = $coord;
    }
    return $newCoords;
}


foreach ($folds as $fold) {
    $coords = fold($coords, $fold['axis'], $fold['position']);
}


$maxX = max(array_column($coords, 'x'));
$maxY = max(array_column($coords, 'y'));

echo $maxX, 'x', $maxY, "\n";

for ($y = 0; $y <= $maxY; $y++) {
    for ($x = 0; $x <= $maxX; $x++) {
        echo (isset($coords["{$x},{$y}"]) ? '#' : '.');
    }
    echo "\n";
}

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

