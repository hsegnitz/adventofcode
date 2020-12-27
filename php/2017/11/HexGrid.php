<?php

use JetBrains\PhpStorm\Pure;

// double height grid
// https://www.redblobgames.com/grids/hexagons/#distances

class HexGrid
{
    private int $x;
    private int $y;

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    private function step(string $direction): void
    {
        switch ($direction) {
            case "n":
                $this->y -= 2;
                break;
            case "s":
                $this->y += 2;
                break;
            case "nw":
                --$this->x;
                --$this->y;
                break;
            case "sw":
                --$this->x;
                ++$this->y;
                break;
            case "ne":
                ++$this->x;
                --$this->y;
                break;
            case "se":
                ++$this->x;
                ++$this->y;
                break;
            default:
                throw new RuntimeException('WTF?|' . $direction);
        }
    }

    public function path(string $instructions): void
    {
        foreach (explode(',', $instructions) as $direction) {
            $this->step($direction);
        }
    }

    #[Pure]
    public function getDistanceTo(int $refX = 0, int $refY = 0): int
    {
        $dx = abs($this->x - $refX);
        $dy = abs($this->y - $refY);
        return $dx + max (0, ($dy-$dx)/2);
    }
}
