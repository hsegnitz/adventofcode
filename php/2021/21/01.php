<?php

$startTime = microtime(true);

//demo
#$posPlayer1 = 4; $posPlayer2 = 8;

//real
$posPlayer1 = 2; $posPlayer2 = 8;

class DeterministicDie
{
    private const max = 100;
    private int $rolls = 0;

    public function roll(): int
    {
        return ($this->rolls++ % self::max) + 1;
    }

    public function getRolls(): int
    {
        return $this->rolls;
    }
}

$die = new DeterministicDie();

//for ($i = 0; $i < 105; $i++) {
//    echo $i, ': ', $die->roll(), "\n";
//}

$scorePlayer1 = $scorePlayer2 = 0;
$turn = 0;
while ($scorePlayer1 < 1000 && $scorePlayer2 < 1000) {
    $moves = 0;
    for ($i = 0; $i < 3; $i++) {
        $moves += $die->roll();
    }

    if ($turn++ % 2 === 0) {
        $posPlayer1 = (($posPlayer1 - 1 + $moves) % 10) + 1;
        $scorePlayer1 += $posPlayer1;
        continue;
    }

    $posPlayer2 = (($posPlayer2 - 1 + $moves) % 10) + 1;
    $scorePlayer2 += $posPlayer2;
}

echo "Player 1: ", $scorePlayer1, ' ', ($scorePlayer1 * $die->getRolls()), "\n";
echo "Player 2: ", $scorePlayer2, ' ', ($scorePlayer2 * $die->getRolls()), "\n";


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

