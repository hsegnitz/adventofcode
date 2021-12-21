<?php

$startTime = microtime(true);

//demo
#$posPlayer0 = 4; $posPlayer1 = 8;

//real
$posPlayer0 = 2; $posPlayer1 = 8;

// counting possible outcomes of three throws with a 3-sided die   --   1 3 1  is the same like 3 1 1 and the same like 1 2 2
$universeMultipliers = [
    3 => 1,
    4 => 3,
    5 => 6,
    6 => 7,
    7 => 6,
    8 => 3,
    9 => 1,
];


// FORK it maybe cursed recursion solves this

/**
 * @return int[]  --  scores for player 1 and 2
 */
function theForkingGame(int $posPlayer0, int $scorePlayer0, int $posPlayer1, int $scorePlayer1, int $turn): array
{
    if ($scorePlayer0 >= 21) {
        return [1, 0];
    }
    if ($scorePlayer1 >= 21) {
        return [0, 1];
    }

    $sums = [
        0 => 0,
        1 => 0,
    ];

    foreach ($GLOBALS['universeMultipliers'] as $posIncrement => $universeMultiplier) {
        if ($turn % 2 === 0) {
            $newPos = (($posPlayer0 - 1 + $posIncrement) % 10) + 1;
            $newScore = $scorePlayer0 + $newPos;
            $res = theForkingGame(
                $newPos,
                $newScore,
                $posPlayer1,
                $scorePlayer1,
                $turn+1
            );
        } else {
            $newPos = (($posPlayer1 - 1 + $posIncrement) % 10) + 1;
            $newScore = $scorePlayer1 + $newPos;
            $res = theForkingGame(
                $posPlayer0,
                $scorePlayer0,
                $newPos,
                $newScore,
                $turn+1
            );
        }

        $sums[0] += $universeMultiplier * $res[0];
        $sums[1] += $universeMultiplier * $res[1];
    }

    return $sums;
}

print_r(theForkingGame($posPlayer0, 0, $posPlayer1, 0, 0));

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

