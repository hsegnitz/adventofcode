<?php

class BoardingPass
{
    private int $id;
    private int $row;
    private int $col;

    public function __construct(string $bsp)
    {
        $this->row = $this->binarySearch(substr($bsp, 0, 7), 'F');
        $this->col = $this->binarySearch(substr($bsp, 7, 3), 'L');
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getCol(): int
    {
        return $this->col;
    }

    public function getId(): int
    {
        return ($this->getRow() * 8) + $this->getCol();
    }

    private function binarySearch(string $bsp, string $charForLower): int
    {
        $lower = 0;
        $upper = (2 ** strlen($bsp)) -1;

        for ($i = 0; $i < strlen($bsp)-1; $i++) {
            $change = ($upper - $lower + 1) / 2;
            if ($bsp[$i] === $charForLower) {
                $upper -= $change;
            } else {
                $lower += $change;
            }
        }

        if ($bsp[strlen($bsp)-1] === $charForLower) {
            return $lower;
        }
        return $upper;
    }
}

$passes = file('./in.txt');
array_walk($passes, static function (&$value) { $value = trim($value); });

$seatsTaken = [];
foreach ($passes as $rawPass) {
    $bp = new BoardingPass($rawPass);
    echo $rawPass, ': ', $bp->getRow(), " x ", $bp->getCol(), " => ", $bp->getId(), "\n";
    $seatsTaken[] = $bp->getId();
}

$max = max($seatsTaken);
echo "highest (day one): ",  $max, "\n";

sort($seatsTaken);
$takenMap = array_flip($seatsTaken);

for ($i = 1; $i < $max; $i++) {
    if (!isset($takenMap[$i]) && isset($takenMap[$i-1], $takenMap[$i+1])) {
        echo "My Seat: ", $i, "\n";
    }
}
