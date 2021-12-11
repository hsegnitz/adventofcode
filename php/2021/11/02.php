<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');


class map {
    /** @var int[][] */
    private array $grid;

    private int $flashCount = 0;

    /**
     * @param string[] $input
     */
    public function __construct(array $input)
    {
        $this->grid = [];
        foreach ($input as $row) {
            $split = str_split(trim($row));
            array_walk($split, static function (&$value) { $value = (int)$value; });
            $this->grid[] = $split;
        }
    }

    public function step() : void
    {
        $this->flashCount = 0;
        $this->increase();
        while ($this->flash()) {}
        $this->countAndReset();
    }

    private function increase(): void
    {
        foreach ($this->grid as &$row) {
            foreach ($row as &$cell) {
                ++$cell;
            }
        }
    }

    private function flash(): bool
    {
        $newFlashDetected = false;
        foreach ($this->grid as $y => &$row) {
            foreach ($row as $x => &$cell) {
                if ($cell >= 10 && $cell <= 100) {
                    // mark the flash as counted by setting it very high
                    $cell = 100;

                    // cascade
                    $newFlashDetected = $this->increaseForFlash($x, $y) || $newFlashDetected;
                }
            }
        }
        return $newFlashDetected;
    }

    private function increaseForFlash(int $startX, int $startY): bool
    {
        $newFlashDetected = false;
        for ($y = $startY - 1; $y <= $startY + 1; $y++) {
            for ($x = $startX - 1; $x <= $startX + 1; $x++) {
                if (isset($this->grid[$y][$x]) && ++$this->grid[$y][$x] === 10) {
                    $newFlashDetected = true;
                }
            }
        }
        return $newFlashDetected;
    }

    private function countAndReset(): void
    {
        foreach ($this->grid as &$row) {
            foreach ($row as &$cell) {
                if ($cell >= 10) {
                    ++$this->flashCount;
                    $cell = 0;
                }
            }
        }
    }

    public function __toString(): string
    {
        $ret = '';
        foreach ($this->grid as $row) {
            $ret .= implode('', $row) . "\n";
        }
        return $ret;
    }

    public function getFlashCount(): int
    {
        return $this->flashCount;
    }
}

$map = new map($input);
$i = 0;
while ($map->getFlashCount() < 100) {
    $map->step();
    $i++;
}

echo $i;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

