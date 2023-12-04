<?php

namespace Year2023\Day04;

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

class Card
{
    private array $winningNumbers;
    private array $myNumbers;
    public int $id;
    public function __construct (string $raw)
    {
        $split = explode(': ', $raw);
        [, $this->id] = preg_split("|\s+|", $split[0]);
        $split2 = explode(" | ", $split[1]);
        $this->winningNumbers = preg_split("|\s+|", $split2[0]);
        $this->myNumbers = preg_split("|\s+|", $split2[1]);
    }

    public function getScore(): int
    {
        return 2 ** ($this->getNumberOfMatches()-1);
    }

    public function getNumberOfMatches(): int
    {
        $res = array_intersect($this->winningNumbers, $this->myNumbers);
        return count($res);
    }
}

$sum = 0;
$cards = [];
foreach ($lines as $line) {
    $card = new Card($line);
    $cards[$card->id] = $card;
    $sum += $card->getScore();
}

$maxId = $card->id;
echo $sum, "\n";

$counts = array_fill(1, $maxId, 1);

foreach ($cards as $card) {
    $toAdd = $counts[$card->id];
    for ($i = 1; $i <= $card->getNumberOfMatches(); $i++) {
        if ($card->id + $i > $maxId) {
            break;
        }
        $counts[$card->id + $i] += $toAdd;
    }
    #print_r($counts);
}


echo array_sum($counts), "\n";

