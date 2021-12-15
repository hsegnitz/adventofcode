<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

class AdventOfHeap extends SplMinHeap
{
    protected function compare(mixed $value1, mixed $value2): int
    {
        return $value2['distance'] - $value1['distance'];
    }
}


class Solver {

    private array $map = [];
    private array $visited = [];
    private AdventOfHeap $heap;
    private string $finalCoord;

    public function __construct(string $input)
    {
        $rows = explode("\n", $input);
        foreach ($rows as $row) {
            $this->map[] = str_split(trim($row));
        }

        $this->finalCoord = count($this->map[0])-1 . "," . count($this->map)-1;

        $this->heap = new AdventOfHeap();
        $this->heap->insert(['x' => 0, 'y' => 0, 'distance' => 0]);
    }

    private function getNeighbours(int $x, int $y): array
    {
        $neighbours = [];
        if (isset($this->map[$y-1][$x])) {
            $neighbours[] = ['x' => $x,   'y' => $y-1, 'distance' => $this->map[$y-1][$x]];
        }
        if (isset($this->map[$y][$x-1])) {
            $neighbours[] = ['x' => $x-1, 'y' => $y,   'distance' => $this->map[$y][$x-1]];
        }
        if (isset($this->map[$y][$x+1])) {
            $neighbours[] = ['x' => $x+1, 'y' => $y,   'distance' => $this->map[$y][$x+1]];
        }
        if (isset($this->map[$y+1][$x])) {
            $neighbours[] = ['x' => $x,   'y' => $y+1, 'distance' => $this->map[$y+1][$x]];
        }
        return $neighbours;
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

$solver = new Solver($input);

$solver->walk();

print_r($solver->getDistanceOfFinalTile());

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

