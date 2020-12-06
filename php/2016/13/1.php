<?php

// "1" == asc(49)

// we (try to) solve this with recursion!!!111oneeleven
// we keep a list of already visited places and how many steps away they are.
// we check if we can walk into a direction and if that direction hasn't been visited before
// if it is so, we return back. When the right coordinates are found, we DIE with distance.

class PathFinder {

    private int $seed;
    private int $targetX;
    private int $targetY;

    private array $visitedSpots = [];

    public function __construct(int $seed, int $targetX, int $targetY)
    {
        $this->seed    = $seed;
        $this->targetX = $targetX;
        $this->targetY = $targetY;
    }

    private function isOpen(int $x, int $y): bool
    {
        $num = ($x * $x) + (3 * $x) + (2 * $x * $y) + $y + ($y * $y);
        $num += $this->seed;
        $binary = base_convert($num, 10, 2);
        $chars = count_chars($binary, 1);
        return $chars[49] % 2 === 0;
    }

    private function hasBeenAlreadyVisited(int $x, int $y, int $newDistance): bool
    {
        if (!isset($this->visitedSpots[$y])) {
            $this->visitedSpots[$y] = [
                $x => $newDistance
            ];
            return false;
        }
        if (!isset($this->visitedSpots[$y][$x])) {
            $this->visitedSpots[$y][$x] = $newDistance;
            return false;
        }
        $this->visitedSpots[$y][$x] = min($this->visitedSpots[$y][$x], $newDistance);
        return true;
    }

    public function walk(int $x, int $y, int $newDistance): int
    {
        if ($this->targetX === $x && $this->targetY === $y) {
            return $newDistance;
        }

        if (!$this->isOpen($x, $y)) {
            return 0;
        }

        if ($this->hasBeenAlreadyVisited($x, $y, $newDistance)) {
            return 0;
        }

        $results = [];
        if (($x > 0) && 0 < ($temp = $this->walk($x - 1, $y, $newDistance + 1))) {
            $results[] = $temp;
        }

        if (($x < 1000) && 0 < ($temp = $this->walk($x + 1, $y, $newDistance + 1))) {
            $results[] = $temp;
        }

        if (($y > 0) && 0 < ($temp = $this->walk($x, $y - 1, $newDistance + 1))) {
            $results[] = $temp;
        }

        if (($y < 1000) && 0 < ($temp = $this->walk($x, $y + 1, $newDistance + 1))) {
            $results[] = $temp;
        }

        if ($results === []) {
            return 0;
        }

        return min($results);
    }
}

/*
for ($y = 0; $y < 50; $y++) {
    for ($x = 0; $x < 50; $x++) {
        if (isOpen($x, $y)) {
            echo ".";
        } else {
            echo "#";
        }
    }
    echo "\n";
}
*/

//$pathFinder = new PathFinder(10, 1, 1);
//echo $pathFinder->walk(1, 1, 1), "\n";

//$pathFinder = new PathFinder(10, 7, 4);
//echo $pathFinder->walk(1, 1, 0), "\n";

$pathFinder = new PathFinder(1350, 31, 39);
echo $pathFinder->walk(1, 1, 0), "\n";
