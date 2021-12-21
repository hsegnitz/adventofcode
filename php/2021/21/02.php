<?php

$startTime = microtime(true);

//demo
$posPlayer1 = 4; $posPlayer2 = 8;

//real
#$posPlayer1 = 2; $posPlayer2 = 8;

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

// these indexes are "pos,score" as we can't have arrays as keys in PHP
// maybe refactor one day into SplObjectStorage?!
$gamesWithScore1 = ["{$posPlayer1},0" => 1];
$gamesWithScore2 = ["{$posPlayer2},0" => 1];

$gamesWon1 = 0;
$gamesWon2 = 0;

// iteration start

function theForkingGame(array &$myGamesWithScore, array &$theirGamesWithScore, int &$myGamesWon): void
{
    $openGames = 0;
    $newGamesWithScore = [];
    foreach ($myGamesWithScore as $key => $count) {
        [$pos, $score] = explode(',', $key);
        foreach ($GLOBALS['universeMultipliers'] as $positionIncrease => $multiplier) {
            $tempPos = (((int)$pos - 1 + $positionIncrease) % 10) + 1;
            $tempScore = (int)$score + $tempPos;
            $tempCount = $count * $multiplier;
            if ($tempScore >= 21) {
                $myGamesWon += $tempCount;
                continue;
            }
            if (!isset($newGamesWithScore["{$tempPos},{$tempScore}"])) {
                $newGamesWithScore["{$tempPos},{$tempScore}"] = 0;
            }
            $newGamesWithScore["{$tempPos},{$tempScore}"] += $tempCount;
            $openGames += $tempCount;
        }
    }
    $myGamesWithScore = $newGamesWithScore;

    // player 2  --  neither position nor score changes for player 2, but the number of universes multiplies!
    // but only if player 1 didn't win with that move.
    $newGamesWithScore2 = [];
    foreach ($theirGamesWithScore as $posScore => $cnt) {
        $newGamesWithScore2[$posScore] = $cnt * $openGames;
    }
    $theirGamesWithScore = $newGamesWithScore2;
}

function debug($gamesWithScore1, $gamesWithScore2, $gamesWon1, $gamesWon2)
{
    echo "Player 1: won ($gamesWon1)\n";
    print_r($gamesWithScore1);

    echo "\nPlayer 2: won ($gamesWon2)\n";
    print_r($gamesWithScore2);
}

debug($gamesWithScore1, $gamesWithScore2, $gamesWon1, $gamesWon2);

$i = 0;
while (count($gamesWithScore1) > 0 && count($gamesWithScore2) > 0) {
    if ($i++ % 2 === 0) {
        theForkingGame($gamesWithScore1, $gamesWithScore2, $gamesWon1);
        echo $gamesWon1, ':', $gamesWon2, "\n";
        continue;
    }
    theForkingGame($gamesWithScore2, $gamesWithScore1, $gamesWon2);
    echo $gamesWon1, ':', $gamesWon2, "\n";
}

debug($gamesWithScore1, $gamesWithScore2, $gamesWon1, $gamesWon2);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

