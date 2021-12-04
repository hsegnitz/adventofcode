<?php

namespace Y2017\D13;

class scanner
{
    private int $depth;
    private int $position;

    public function __construct(int $position, int $depth) {
        $this->position = $position;
        $this->depth = $depth;
    }

    public function isHitWhenStartedAt(int $picoSecond): bool {
        $scannerVPos = ($this->position + $picoSecond) % (($this->depth * 2) -2);
        return $scannerVPos === 0;
    }

    public function getSeverity(): int
    {
        return $this->depth * $this->position;
    }
}
