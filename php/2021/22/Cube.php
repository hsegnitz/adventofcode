<?php

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
        return (abs($this->xTo - $this->xFrom)+1) * (abs($this->yTo - $this->yFrom)+1) * (abs($this->zTo - $this->zFrom)+1);
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

    
}
