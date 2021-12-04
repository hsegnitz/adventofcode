<?php

$startTime = microtime(true);



class board {

    private $board = [];

    public function __construct(array $rawBoard)
    {
        foreach ($rawBoard as $row) {
            $this->board[] = preg_split('/\s+/', trim($row));
        }
    }

    public function registerNumber(int $number): void
    {
        foreach ($this->board as $rowNum => $row) {
            foreach ($row as $colNum => $cell) {
                if ($cell == $number) {
                    $this->board[$rowNum][$colNum] = -1;
                    return;
                }
            }
        }
    }

    public function isWinner(): bool
    {
        $target = array_fill(0, 5, -1);
        foreach ($this->board as $rowNum => $row) {
            if ($row == $target) {
                return true;
            }
            if (array_column($this->board, $rowNum) == $target) {
                return true;
            }
        }
        return false;
    }

    public function __toString(): string
    {
        $out = [];
        foreach ($this->board as $row) {
            $out[] = implode("  ", $row);
        }
        return implode("\n", $out);
    }

    public function getSumUnmarked(): int
    {
        $sum = 0;
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                if ($cell > -1) {
                    $sum += $cell;
                }
            }
        }
        return $sum;
    }
}


#$input = file('./example.txt');
$input = file('./in.txt');

$first = array_shift($input);
$numbers = explode(",", trim($first));

$rawBoards = array_chunk($input, 6);

$boards = [];
foreach ($rawBoards as $rawBoard) {
    array_shift($rawBoard);
    $boards[] = new \board($rawBoard);
}

foreach ($numbers as $number) {
    $numAsInt = (int)$number;
    foreach ($boards as $board) {
        $board->registerNumber($number);
        if  ($board->isWinner()) {
            break 2;
        }
    }
}

$result = $number * $board->getSumUnmarked();

echo $result, "\ntotal time: ", (microtime(true) - $startTime), "\n";


