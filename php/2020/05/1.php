<?php

class BoardingPass
{
    private int $id;
    private int $row;
    private int $col;

    public function __construct(string $bsp)
    {
        $this->row = $this->binarySearch(substr($bsp, 0, 7), 'F');
    }

    public function getRow(): int
    {
        return $this->row;
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

$bp = new BoardingPass('FBFBBFFRLR');
echo $bp->getRow();






echo "\n";
