<?php

$startTime = microtime(true);

$input = file('example.txt', FILE_IGNORE_NEW_LINES);
#$input = file('in.txt', FILE_IGNORE_NEW_LINES);

$map = [];
foreach ($input as $row) {
    $map[] = str_split(trim($row));
}

$visibility = [];
$scores = [];

$maxRowNum = count($map) - 1;
$maxColNum = count($map[0]) - 1;

foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $cell) {
        if ($rowNum === 0 || $rowNum === $maxRowNum || $colNum === 0 || $colNum === $maxColNum || isVisible($map, $rowNum, $colNum)) {
            $visibility["{$rowNum}-{$colNum}"] = 1;
        }
        $scores["{$rowNum}-{$colNum}"] = scenicScore($map, $rowNum, $colNum);
    }
}


function scenicScore(array $map, int $rowNum, int $colNum): int {
    $maxRowNum = count($map) - 1;
    $maxColNum = count($map[0]) - 1;

    // quick exit for edges as having one zero in the list means the score is zero
    if ($rowNum === 0 || $rowNum === $maxRowNum || $colNum === 0 || $colNum === $maxColNum) {
        return 0;
    }

    $slices = [
        getGridSlice($map, $rowNum, $colNum, -1,  0), #up
        getGridSlice($map, $rowNum, $colNum,  0, -1), #left
        getGridSlice($map, $rowNum, $colNum,  1,  0), #down
        getGridSlice($map, $rowNum, $colNum,  0,  1), #right
    ];

    $ownHeight = $map[$rowNum][$colNum];

    $visibilities = [];
    foreach ($slices as $slice) {
        $count = 0;
        foreach ($slice as $seq => $tree) {
            $count++;
            if ($tree >= $ownHeight) {
                break;
            }
        }
        $visibilities[] = $count;
    }

    return array_product($visibilities);
}

function isVisible (array $map, int $rowNum, int $colNum): bool {
    return
        max(   getGridSlice($map, $rowNum, $colNum,  1,  0)) < $map[$rowNum][$colNum]
        || max(getGridSlice($map, $rowNum, $colNum, -1,  0)) < $map[$rowNum][$colNum]
        || max(getGridSlice($map, $rowNum, $colNum,  0,  1)) < $map[$rowNum][$colNum]
        || max(getGridSlice($map, $rowNum, $colNum,  0, -1)) < $map[$rowNum][$colNum];
}

function getGridSlice(array $map, int $rowNum, int $colNum, int $rowDelta, int $colDelta): array {
    $maxRowNum = count($map) - 1;
    $maxColNum = count($map[0]) - 1;

    $out = [];
    while ($rowNum > 0 && $rowNum < $maxRowNum && $colNum > 0 && $colNum < $maxColNum) {
        $rowNum += $rowDelta;
        $colNum += $colDelta;
        $out[] = $map[$rowNum][$colNum];
    }
    return $out;
}

echo "Part 1: ", count($visibility);
echo "\nPart 2: ", max($scores);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

