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


$rounds = 0;
while (count($player1) > 0 && count($player2) > 0) {
    ++$rounds;
    $card1 = array_shift($player1);
    $card2 = array_shift($player2);
    if ($card1 > $card2) {
        $player1[] = $card1;
        $player1[] = $card2;
    } else {
        $player2[] = $card2;
        $player2[] = $card1;
    }
}

echo $rounds, "\n";
print_r($player1);
print_r($player2);

if (count($player1) > 0) {
    $winner = $player1;
} else {
    $winner = $player2;
}

$winner[] = 0;
$scores = array_reverse($winner);

print_r($scores);

$score = 0;
foreach ($scores as $k => $v) {
    $score += $k * $v;
}

echo $score;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
