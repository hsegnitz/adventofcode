<?php

// "1" == asc(49)

class PathFinder {

    private int $seed;
    private int $targetX;
    private int $targetY;

    private array $map = [];

    private array $visitedSpots = [];

    private int $shortestPath = PHP_INT_MAX;

    public function __construct(int $seed, int $targetX, int $targetY)
    {
        $this->seed    = $seed;
        $this->targetX = $targetX;
        $this->targetY = $targetY;
    }

    public function isOpen(int $x, int $y): bool
    {
        if (!isset($this->map[$y][$x])) {
            if (!isset($this->map[$y])) {
                $this->map[$y] = [];
            }
            $num = ($x * $x) + (3 * $x) + (2 * $x * $y) + $y + ($y * $y);
            $num += $this->seed;
            $binary = base_convert($num, 10, 2);
            $chars = count_chars($binary, 1);
            $this->map[$y][$x] = ($chars[49] % 2 === 0);
        }

        return $this->map[$y][$x];
    }

    private function registerVisitedAndGetDistance(int $x, int $y, int $newDistance): int
    {
        $coord = "{$x},{$y}";
        if (!isset($this->visitedSpots[$coord])) {
            $this->visitedSpots[$coord] = $newDistance;
            return PHP_INT_MAX;
        }
        $this->visitedSpots[$coord] = min($newDistance, $this->visitedSpots[$coord]);
        return $this->visitedSpots[$coord];
    }

    public function walk(int $x, int $y, int $newDistance): int
    {
        if ($this->targetX === $x && $this->targetY === $y) {
            $this->shortestPath = min($newDistance, $this->shortestPath);
            return $this->shortestPath;
        }

        // either too far away or a wall
        if ($newDistance > 200 || !$this->isOpen($x, $y)) {
            return 0;
        }

        // if not visited, we get PHP_INT_MAX so this means we continue from here as we obviously found a shorter path
        if ($newDistance > $this->registerVisitedAndGetDistance($x, $y, $newDistance)) {
            return 0;
        }

        #echo $x, ",", $y, "\n";

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

//$pathFinder = new PathFinder(10, 1, 1);
//echo $pathFinder->walk(1, 1, 1), "\n";

#$pathFinder = new PathFinder(10, 7, 4);
#echo $pathFinder->walk(1, 1, 0), "\n";


/*  */
$pathFinder = new PathFinder(1350, 31, 39);
echo $pathFinder->walk(1, 1, 0), "\n";
/*   * /
for ($y = 0; $y < 50; $y++) {
    for ($x = 0; $x < 50; $x++) {
        if ($pathFinder->isOpen($x, $y)) {
            echo ".";
        } else {
            echo "#";
        }
    }
    echo "\n";
}

/*   */