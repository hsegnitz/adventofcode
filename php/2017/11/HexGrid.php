<?php

use JetBrains\PhpStorm\Pure;

class HexGrid
{
    private int $posQ;
    private int $posR;

    public function __construct(int $posQ = 0, int $posR = 0)
    {
        $this->posQ = $posQ;
        $this->posR = $posR;
    }

    private function step(string $direction): void
    {
        switch ($direction) {
            case "n":
                --$this->posR;
                break;
            case "s":
                ++$this->posR;
                break;
            case "nw":
                $this->posR -= ($this->posQ % 2 === 0) ? 1 : 0;
                --$this->posQ;
                break;
            case "sw":
                $this->posR += $this->posQ % 2;
                --$this->posQ;
                break;
            case "ne":
                $this->posR -= ($this->posQ % 2 === 0) ? 1 : 0;
                ++$this->posQ;
                break;
            case "se":
                $this->posR += $this->posQ % 2;
                ++$this->posQ;
                break;
            default:
                throw new RuntimeException('WTF?|' . $direction);
        }
    }

    private function hexDistance(int $aq, int $ar, int $bq, int $br): int
    {
        [$ax, $ay, $az] = $this->oddq2cube($aq, $ar);
        [$bx, $by, $bz] = $this->oddq2cube($bq, $br);
        return $this->cubeDistance($ax, $ay, $az, $bx, $by, $bz);
    }

    #[Pure]
    private function cubeDistance(int $ax, int $ay, int $az, int $bx, int $by, int $bz): int
    {
        return (abs($ax - $bx) + abs($ay - $by) + abs($az - $bz)) / 2;
    }

    private function oddq2cube(int $q, int $r): array
    {
        $x = $q;
        $z = $r - ($x - ($x&1)) / 2;
        $y = - $x-$z;

        return [$x, $y, $z];
    }

    public function path(string $instructions): void
    {
        foreach (explode(',', $instructions) as $direction) {
            $this->step($direction);
        }
    }

    public function getDistanceTo(int $refQ = 0, int $refR = 0): int
    {
        return $this->hexDistance($this->posQ, $this->posR, $refQ, $refR);
    }
}
