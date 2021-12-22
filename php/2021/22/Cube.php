<?php

// we changed the interpretation of coordinates a bit and make the upper bound now exclusive, thus needing
// to add 1 while reading the input.  --  just FYI

class Cube
{
    public function __construct(
        public readonly int $xFrom,
        public readonly int $xTo,
        public readonly int $yFrom,
        public readonly int $yTo,
        public readonly int $zFrom,
        public readonly int $zTo
    ) {}

    public function volume(): int
    {
        return (abs($this->xTo - $this->xFrom)) * (abs($this->yTo - $this->yFrom)) * (abs($this->zTo - $this->zFrom));
    }

    public function intersectsWith(Cube $otherCube): bool
    {
        return ($this->xFrom < $otherCube->xTo) && ($this->xTo > $otherCube->xFrom)
            && ($this->yFrom < $otherCube->yTo) && ($this->yTo > $otherCube->yFrom)
            && ($this->zFrom < $otherCube->zTo) && ($this->zTo > $otherCube->zFrom);
    }

    public function fullyContains(Cube $otherCube): bool
    {
        return ($this->xFrom <= $otherCube->xFrom) && ($this->xTo >= $otherCube->xTo)
            && ($this->yFrom <= $otherCube->yFrom) && ($this->yTo >= $otherCube->yTo)
            && ($this->zFrom <= $otherCube->zFrom) && ($this->zTo >= $otherCube->zTo);
    }

    /**
     * Axes go: x right, y deep, z up
     * @return Cube[]
     */
    public function subtract(Cube $b): array
    {
        $newCubes = [];
        $cutsX = [$this->xFrom, $this->xTo, $b->xFrom, $b->xTo];
        $cutsY = [$this->yFrom, $this->yTo, $b->yFrom, $b->yTo];
        $cutsZ = [$this->zFrom, $this->zTo, $b->zFrom, $b->zTo];
        sort($cutsX);
        sort($cutsY);
        sort($cutsZ);

        for ($x = 0; $x < 3; $x++) {
            for ($y = 0; $y < 3; $y++) {
                for ($z = 0; $z < 3; $z++) {
                    $testCube = new Cube (
                        $cutsX[$x],
                        $cutsX[$x+1],
                        $cutsY[$y],
                        $cutsY[$y+1],
                        $cutsZ[$z],
                        $cutsZ[$z+1],
                    );
                    if ($this->fullyContains($testCube) && !$b->fullyContains($testCube)) {
                        $newCubes[] = $testCube;
                    }
                }
            }
        }
        return $newCubes;
    }
}
