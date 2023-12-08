<?php

namespace Year2023\Day07;

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


class Hand {
    private CONST CARDS_VALUES = [
        'J' => '01',
        2   => '02',
        3   => '03',
        4   => '04',
        5   => '05',
        6   => '06',
        7   => '07',
        8   => '08',
        9   => '09',
        'T' => '10',
        'Q' => '12',
        'K' => '13',
        'A' => '14',
    ];

    private const SORT_SCORES = [
        'fiveOfAKind'  => 700000000000,
        'fourOfAKind'  => 600000000000,
        'fullHouse'    => 500000000000,
        'threeOfAKind' => 400000000000,
        'twoPair'      => 300000000000,
        'onePair'      => 200000000000,
        'highCard'     => 100000000000,
    ];

    private array $cards = [];
    private int $bid;

    private int $sortScore = 0;
    public function __construct(public string $raw)
    {
        [$cards, $this->bid] = explode(" ", $raw);
        $cards = str_split($cards);
        foreach ($cards as $card) {
            $this->cards[] = self::CARDS_VALUES[$card];
        }
        $this->sortScore = (int)implode("", $this->cards);
        rsort($this->cards);
        $this->determineSortScore();
    }

    public function getBid(): int
    {
        return $this->bid;
    }
    private function determineSortScore(): void
    {
        // five of a kind  -- cards are ordered, they are the same if first and last have the same value
        if ($this->cards[0] === $this->cards[4]) {
            $this->sortScore += self::SORT_SCORES['fiveOfAKind'];
            return;
        }

        // four of a kind  -- cards are ordered, they are the same if first and penultimate have the same value  or the second and the last
        if ($this->cards[0] === $this->cards[3] || $this->cards[1] === $this->cards[4]) {
            if ($this->cards[4] === '01') {
                $this->sortScore += self::SORT_SCORES['fiveOfAKind'];
            } else {
                $this->sortScore += self::SORT_SCORES['fourOfAKind'];
            }
            return;
        }

        // fullHouse
        if (($this->cards[0] === $this->cards[1] && $this->cards[2] === $this->cards[4]) || ($this->cards[0] === $this->cards[2] && $this->cards[3] === $this->cards[4])) {
            if ($this->cards[4] == '01') {
                $this->sortScore += self::SORT_SCORES['fiveOfAKind'];
            } else {
                $this->sortScore += self::SORT_SCORES['fullHouse'];
            }
            return;
        }

        // three of a kind
        if ($this->cards[0] === $this->cards[2] || $this->cards[1] === $this->cards[3] || $this->cards[2] === $this->cards[4]) {
            if ($this->cards[4] === '01') {
                $this->sortScore += self::SORT_SCORES['fourOfAKind'];
                return;
            }
            $this->sortScore += self::SORT_SCORES['threeOfAKind'];
            return;
        }

        // twoPair
        if (($this->cards[0] === $this->cards[1] && $this->cards[2] === $this->cards[3])) {
            if ($this->cards[4] === '01') {
                $this->sortScore += self::SORT_SCORES['fullHouse'];
                return;
            }
            $this->sortScore += self::SORT_SCORES['twoPair'];
            return;
        }
        if (($this->cards[1] === $this->cards[2] && $this->cards[3] === $this->cards[4])
            || ($this->cards[0] === $this->cards[1] && $this->cards[3] === $this->cards[4])) {
            if ($this->cards[4] === '01') {
                $this->sortScore += self::SORT_SCORES['fourOfAKind'];
                return;
            }
            $this->sortScore += self::SORT_SCORES['twoPair'];
            return;
        }

        // onePair
        if ($this->cards[0] === $this->cards[1] || $this->cards[1] === $this->cards[2] || $this->cards[2] === $this->cards[3] || $this->cards[3] === $this->cards[4]) {
            if ($this->cards[4] == '01') {
                $this->sortScore += self::SORT_SCORES['threeOfAKind'];
                return;
            }
            $this->sortScore += self::SORT_SCORES['onePair'];
            return;
        }

        // HighCard
        if ($this->cards[4] == '01') {
            $this->sortScore += self::SORT_SCORES['onePair'];
            return;
        }
        $this->sortScore += self::SORT_SCORES['highCard'];
    }

    public function getSortScore(): int
    {
        return $this->sortScore;
    }
}

$hands = [];
foreach ($lines as $line) {
    $hands[] = $hand = new Hand($line);
    #echo $hand->raw, ": ", $hand->getSortScore(), "\n";
}

echo "\n\n";

usort($hands, function (Hand $a, Hand $b) {
    return $a->getSortScore() <=> $b->getSortScore();
});

$sum = 0;
foreach ($hands as $pos => $hand) {
    #echo $hand->getSortScore(), " ", $hand->raw, ": ", ($pos + 1), " * ", $hand->getBid(), " => ", ($partScore = (($pos + 1) * $hand->getBid())), "\n";
    $sum += (($pos + 1) * $hand->getBid());
}

echo "\n", $sum, "\n";

echo microtime(true) - $start;
echo "\n";

