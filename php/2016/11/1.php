<?php

// this is the extended version of the riddle of the man who needs to cross a river with a fox, rabbit and cabbage.
// for reference see Fargo Season 1 :D
//

// manual reading
// actual
$itemsDistribution = [
    0 => 2,
    1 => 4,
    2 => 4,
    3 => 0,
];

// demo
//$itemsDistribution = [
//    0 => 2,
//    1 => 1,
//    2 => 1,
//    3 => 0,
//];

function minMoves($floors): int
{
    $itemCount = array_sum($floors);
    $moves = 0;
    $floor = 0;
    $onElevator = min($floors[0], 2);

    while ($floors[3]+1 !== $itemCount) {
        while ($onElevator < 2 && $floor > 0) {
            $floor--;
            $pickedUpItems = min($floors[$floor], 2 - $onElevator);
            if ($pickedUpItems > 0) {
                $onElevator += $pickedUpItems;
                $floors[$floor] -= $pickedUpItems;
            }
            $moves++;
        }

        while ($floor < 3) {
            $floor++;
            $pickedUpItems = min($floors[$floor], 2 - $onElevator);
            if ($pickedUpItems > 0) {
                $onElevator += $pickedUpItems;
                $floors[$floor] -= $pickedUpItems;
            }
            $moves++;
        }

        $floors[3] += 1;
        $onElevator--;
    }

    return $moves;
}

echo minMoves($itemsDistribution), "\n";
