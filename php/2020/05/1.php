<?php

class BoardingPass
{
    private int $id;
    private int $row;
    private int $col;

    public function __construct(string $bsp)
    {
        $lower = 0;
        $upper = 127;

        for ($i = 0; $i < 6; $i++) {
            $change = ($upper - $lower + 1) / 2;
            if ($bsp[$i] === 'F') {
                $upper -= $change;
            } else {
                $lower += $change;
            }
        }

        if ($bsp[6] === 'F') {
            $this->row = $lower;
        } else {
            $this->row = $upper;
        }
    }

    public function getRow(): int
    {
        return $this->row;
    }

}

$bp = new BoardingPass('FBFBBFFRLR');
echo $bp->getRow();






echo "\n";
