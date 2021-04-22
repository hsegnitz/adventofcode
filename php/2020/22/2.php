<?php

$startTime = microtime(true);

$player1 = [];
$player2 = [];

[$rawPlayer1, $rawPlayer2] = explode("\n\n", trim(file_get_contents(__DIR__ . '/in.txt')));

$split = explode("\n", $rawPlayer1);
array_shift($split);
$player1 = array_map("intval", $split);
#print_r($player1);

$split = explode("\n", $rawPlayer2);
array_shift($split);
$player2 = array_map("intval", $split);
#print_r($player2);

// return ["player(1|2)", [...cards...]]
function playGame(array $player1, array $player2): array
{
    $seen = [];
    while (true) {
        $hash = implode(",", $player1) . '|' . implode(",", $player2);
        if (isset($seen[$hash])) {
            #echo "Player 1 wins";
            return ["player1", $player1];
        }
        $seen[$hash] = true;

        $card1 = array_shift($player1);
        $card2 = array_shift($player2);

        // check if both players stacks are larger than their card's value
        if (count($player1) >= $card1 && count($player2) >= $card2) {
            [$winner, $innerCards] = playGame(
                array_slice($player1, 0, $card1),
                array_slice($player2, 0, $card2)
            );
            if ($winner === "player1") {
                $player1[] = $card1;
                $player1[] = $card2;
            } else {
                $player2[] = $card2;
                $player2[] = $card1;
            }
        } else {
            if ($card1 > $card2) {
                $player1[] = $card1;
                $player1[] = $card2;
            } else {
                $player2[] = $card2;
                $player2[] = $card1;
            }
        }

        if (count($player1) === 0) {
            return ["player2", $player2];
        }
        if (count($player2) === 0) {
            return ["player1", $player1];
        }
    }
}

[$winner, $cards] = playGame($player1, $player2);

echo "winner: ", $winner, "\n";

$cards[] = 0;
$scores = array_reverse($cards);

print_r($scores);

$score = 0;
foreach ($scores as $k => $v) {
    $score += $k * $v;
}

echo $score;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
