<?php

namespace Year2023\Day02;

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

class Game {
    private const MAX_RED = 12;
    private const MAX_GREEN = 13;
    private const MAX_BLUE = 14;

    public int $id;

    private array $draws = [];
    public function __construct(string $in)
    {
        $split = explode(": ", $in);
        $gameSplit = explode(" ", array_shift($split));
        $this->id = (int)$gameSplit[1];
        foreach (explode("; ", $split[0]) as $rawDraw) {
            $this->draws[] = new Draw($rawDraw);
        }
    }

    public function isValid(): bool
    {
        foreach ($this->draws as $draw) {
            if (!$draw->isValid(self::MAX_RED, self::MAX_GREEN, self::MAX_BLUE)) {
                return false;
            }
        }
        return true;
    }

    public function getPower(): int
    {
        $reds = $blues = $greens = [0];
        foreach ($this->draws as $draw) {
            $reds[] = $draw->red;
            $blues[] = $draw->blue;
            $greens[] = $draw->green;
        }
        return max($reds) * max($greens) * max($blues);
    }
}

class Draw
{
    public int $red = 0;
    public int $green = 0;
    public int $blue = 0;

    public function __construct(string $in)
    {
        foreach (explode(", ", $in) as $c) {
            [$count, $color] = explode(" ", $c);
            $this->$color = (int)$count;
        }
    }

    public function isValid(int $maxRed, int $maxGreen, int $maxBlue): bool
    {
        return ($this->red <= $maxRed && $this->green <= $maxGreen && $this->blue <= $maxBlue);
    }
}

$sum = $totalPower = 0;
foreach ($lines as $line) {
    #echo $line;
    $game = new Game($line);
    echo $game->id, ": ";
    if ($game->isValid()) {
        $sum += $game->id;

    }
    echo $power = $game->getPower(), "\n";
    $totalPower += $power;
}

echo $sum, "\n";
echo $totalPower, "\n";
