<?php

$startTime = microtime(true);

$map = [];
foreach (file(__DIR__ . '/in.txt') as $line) {
    $map[] = str_split(trim($line));
}

$specialCoords = [];
foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $field) {
        if ($field !== '.' && $field !== '#') {
            $specialCoords[$field] = [
                'col' => $colNum,
                'row' => $rowNum,
            ];
        }
    }
}

#print_r($specialCoords);
#die();
// find the shortest routes between those coords  (from day 13?) -- needs optimisation
class PathFinder
{
    private array $map;

    private int $targetX;
    private int $targetY;

    private array $visitedSpots;

    private int $shortestPath;

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function setTarget(int $targetX, int $targetY)
    {
        $this->shortestPath = PHP_INT_MAX;
        $this->visitedSpots = [];
        $this->targetX = $targetX;
        $this->targetY = $targetY;
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
        if ($newDistance > 4000 || $this->map[$y][$x] === '#') {
            return 5000;
        }

        // if not visited, we get PHP_INT_MAX so this means we continue from here as we obviously found a shorter path
        if ($newDistance >= $this->registerVisitedAndGetDistance($x, $y, $newDistance)) {
            return 5000;
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
            return 5000;
        }

        return min($results);
    }
}

$pathFinder = new PathFinder($map);

$distances = [];

foreach ($specialCoords as $a => $ca) {
    foreach ($specialCoords as $b => $cb) {
        if ($a === $b) {
            continue;
        }

        if (isset($distances[$a][$b])) {
            continue;
        }

        $pathFinder->setTarget($ca['col'], $ca['row']);
        $distance = $pathFinder->walk($cb['col'], $cb['row'], 0);
        $distances[$a][$b] = $distance;
        $distances[$b][$a] = $distance;
    }
}

/*
$chain = [0, 1, 6, 4, 5, 7, 3, 2];

$prev = array_shift($chain);

while (null !== ($next = array_shift($chain))) {
    $pathFinder->setTarget($specialCoords[$prev]['col'], $specialCoords[$prev]['row']);
    $distance = $pathFinder->walk($specialCoords[$next]['col'], $specialCoords[$next]['row'], 0);
    $distances[$prev][$next] = $distance;
    $distances[$next][$prev] = $distance;
    $prev = $next;
}
/* * /
 print_r($distances);
 die();
*/

// travelling salesman brute force

function permutatePaths(array $prev, array $options): array
{
    $ret = [];
    foreach ($options as $key => $val) {
        $tempPrev = $prev;
        $tempPrev[] = $val;
        $tempOptions = $options;
        unset($tempOptions[$key]);
        if ([] === $tempOptions) {
            $ret[] = $tempPrev;
        } else {
            $ret = array_merge($ret, permutatePaths($tempPrev, $tempOptions));
        }
    }
    return $ret;
}

$paths = permutatePaths([], array_keys($specialCoords));

function totalDistance(array $points): int
{
    $distance = 0;
    $prev = array_shift($points);
    while (null !== ($next = array_shift($points))) {
        $distance += $GLOBALS['distances'][$prev][$next];
        $prev = $next;
    }
    return $distance;
}

$allDistances = [];
foreach ($paths as $path) {
    if ($path[0] !== 0) {
        continue;
    }
    $td = totalDistance($path);
    if ($td < 1094) {
        $allDistances[$td] = $path;
    }
}

print_r($allDistances);

echo min(array_keys($allDistances));

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
