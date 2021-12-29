<?php

$startTime = microtime(true);

// strategy
// find shortest paths between all the points
// permutate all of them to find the smallest combination


$map = [];

/*     * /
foreach (file(__DIR__ . '/demo.txt', FILE_IGNORE_NEW_LINES) as $line) {
    $map[] = str_split($line);
}
/*     */

/*   */
foreach (file(__DIR__ . '/in.txt', FILE_IGNORE_NEW_LINES) as $line) {
    $map[] = str_split($line);
}
/*  */

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

//print_r($specialCoords);
//die();

class AdventOfHeap extends SplMinHeap
{
    protected function compare(mixed $value1, mixed $value2): int
    {
        return $value2['distance'] - $value1['distance'];
    }
}


class Solver {
    private array $visited = [];
    private AdventOfHeap $heap;
    private string $finalCoord;

    public function __construct(
        private array $map,
        private int $startX,
        private int $startY,
        private int $targetX,
        private int $targetY,
    ) {
        $this->finalCoord = "{$this->targetX},{$this->targetY}";
        $this->heap = new AdventOfHeap();
        $this->heap->insert(['x' => $this->startX, 'y' => $this->startY, 'distance' => 0]);
    }

    private function getNeighbours(int $x, int $y): Generator
    {
        if (isset($this->map[$y-1][$x]) && $this->map[$y-1][$x] !== '#') {
            yield ['x' => $x,   'y' => $y-1, 'distance' => 1];
        }
        if (isset($this->map[$y][$x-1]) && $this->map[$y][$x-1] !== '#') {
            yield ['x' => $x-1, 'y' => $y,   'distance' => 1];
        }
        if (isset($this->map[$y][$x+1]) && $this->map[$y][$x+1] !== '#') {
            yield ['x' => $x+1, 'y' => $y,   'distance' => 1];
        }
        if (isset($this->map[$y+1][$x]) && $this->map[$y+1][$x] !== '#') {
            yield ['x' => $x,   'y' => $y+1, 'distance' => 1];
        }
    }

    public function walk(): void
    {
        while (true) {
            $current = $this->heap->extract();

            foreach ($this->getNeighbours($current['x'], $current['y']) as $next) {
                $coord = $next['x'] . "," .  $next['y'];
                if (isset($this->visited[$coord])) {
                    continue;
                }
                $next['distance'] += $current['distance'];
                $this->heap->insert($next);
                $this->visited[$coord] = $next['distance'];

                if ($coord === $this->finalCoord) {
                    return;
                }
            }
        }
    }

    public function getDistanceOfFinalTile(): int
    {
        return $this->visited[$this->finalCoord];
    }
}

$distances = [];

ksort($specialCoords);

foreach ($specialCoords as $num => $coords) {
    foreach ($specialCoords as $num2 => $coords2) {
        if ($num === $num2) {
            continue;
        }
        $solver = new Solver(
            $map,
            $coords['col'],
            $coords['row'],
            $coords2['col'],
            $coords2['row'],
        );

        $solver->walk();

        $distances[$num][$num2] = $solver->getDistanceOfFinalTile();
        $distances[$num2][$num] = $solver->getDistanceOfFinalTile();
    }
}

#print_r($distances);

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

$keys = array_keys($specialCoords);
unset($keys[0]);

#print_r($keys);
#die();

$paths = permutatePaths([0], $keys);

#print_r($paths);
#die();

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
    $td = totalDistance($path);
    $allDistances[$td] = $path;
}

print_r($allDistances);

echo min(array_keys($allDistances));

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
