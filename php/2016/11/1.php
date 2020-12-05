<?php

// this is the extended version of the riddle of the man who needs to cross a river with a fox, rabbit and cabbage.
// for reference see Fargo Season 1 :D
//

// manual reading
// actual
//$itemsDistribution = [
//    0 => 2,
//    1 => 4,
//    2 => 4,
//    3 => 0,
//];

// demo
$itemsDistribution = [
    0 => 2,
    1 => 1,
    2 => 1,
    3 => 0,
];

function minMoves($itemsDistribution): int
{
    $itemCount = array_sum($itemsDistribution);

    $moves = 0;
    $floor = 0;
    while ($itemsDistribution[3] !== $itemCount) {
        $moves += (2 * $itemsDistribution[$floor]) - 3;
        $itemsDistribution[$floor + 1] += $itemsDistribution[$floor];
        $floor++;
    }

    return $moves;
}

echo minMoves($itemsDistribution), "\n";
