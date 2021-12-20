<?php

$startTime = microtime(true);

#$input = explode("\n\n", str_replace(['.', '#'], ['0', '1'], file_get_contents('./example0.txt')));
$input = explode("\n\n", str_replace(['.', '#'], ['0', '1'], file_get_contents('./in.txt')));


function apply(array $image, string $algo, string $default): array
{
    $newImage = [];
    foreach (array_keys($image) as $coord) {
        [$y, $x] = explode(",", $coord);
        $numString = '';
        foreach (getNumCoords($y, $x) as $numCoord) {
            if (!isset($image[$numCoord])) {
                $numString .= $default;
            } else {
                $numString .= $image[$numCoord];
            }
        }
        $pos = bindec($numString);
        $newImage[$coord] = $algo[$pos];
    }

    return $newImage;
}

function getNumCoords(int $y, int $x): array
{
    return [
        ($y-1) . "," . ($x-1),
        ($y-1) . "," . ($x  ),
        ($y-1) . "," . ($x+1),
        ($y  ) . "," . ($x-1),
        ($y  ) . "," . ($x  ),
        ($y  ) . "," . ($x+1),
        ($y+1) . "," . ($x-1),
        ($y+1) . "," . ($x  ),
        ($y+1) . "," . ($x+1),
    ];
}


// maybe min/max need to be determined later (part2?) during runtime to not grow this too much

function padImage(array $image, int &$minX, int &$minY, int &$maxX, int &$maxY, string $padWith): array
{
    // line above and below
    foreach ([$minY-1, $maxY+1] as $y) {
        for ($x = $minX-1; $x <= $maxX+1; $x++) {
            $image["{$y},{$x}"] = $padWith;
        }
    }

    // col left and right
    for ($y = $minY; $y <= $maxY; $y++) {
        foreach ([$minX-1, $maxX+1] as $x) {
            $image["{$y},{$x}"] = $padWith;
        }
    }

    $minX-=1;
    $minY-=1;
    $maxX+=1;
    $maxY+=1;

    ksort($image);

    return $image;
}

function out($image, int &$minX, int &$minY, int &$maxX, int &$maxY): void
{
    for ($y = $minY; $y <= $maxY; $y++) {
        for ($x = $minX; $x <= $maxX; $x++) {
            echo $image["{$y},{$x}"];
        }
        echo "\n";
    }
}




$algo = $input[0];

$minX = 0;
$minY = 0;
$maxX = 0;
$maxY = 0;

$image = [];
foreach (explode("\n", $input[1]) as $rowNum => $row) {
    foreach (str_split(trim($row)) as $colNum => $cell) {
        $image["{$rowNum},{$colNum}"] = $cell;
    }
}

$maxX = $colNum;
$maxY = $rowNum;

#out($image, $minX, $minY, $maxX, $maxY);

for ($i = 0; $i < 50; $i++) {
    $image = padImage($image, $minX, $minY, $maxX, $maxY, $i%2);
    $image = apply($image, $algo, $i%2);
    #out($image, $minX, $minY, $maxX, $maxY);
    if ($i === 1 || $i === 49) {
        echo "$i: ", array_count_values($image)['1'], "\n";
    }
}


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

