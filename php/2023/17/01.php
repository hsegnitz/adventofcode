<?php

namespace Year2023\Day17;

$start = microtime(true);

$in = file_get_contents('example.txt', FILE_IGNORE_NEW_LINES);
#$in = file_get_contents('input.txt', FILE_IGNORE_NEW_LINES);

class AdventOfHeap extends \SplMinHeap
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

    private const DELTAS = [
        'N' => ['x' =>  0, 'y' => -1],
        'E' => ['x' =>  1, 'y' =>  0],
        'S' => ['x' =>  0, 'y' =>  1],
        'W' => ['x' => -1, 'y' =>  0],
    ];

    public function __construct(string $input)
    {
        $rows = explode("\n", $input);
        foreach ($rows as $row) {
            $this->map[] = str_split(trim($row));
        }

        $this->finalCoord = count($this->map[0])-1 . "," . count($this->map)-1;

        $this->heap = new AdventOfHeap();
        $this->heap->insert(['x' => 0, 'y' => 0, 'distance' => 0, 'direction' => 'E']);
        $this->heap->insert(['x' => 0, 'y' => 0, 'distance' => 0, 'direction' => 'S']);
    }

    private function getNeighbours(int $x, int $y, string $originalDirection): \Generator
    {
        switch ($originalDirection) {
            case "N":
            case "S":
                yield from $this->getNeighboursInDirection($x, $y, 'E');
                yield from $this->getNeighboursInDirection($x, $y, 'W');
                break;
            case "E":
            case "W":
                yield from $this->getNeighboursInDirection($x, $y, 'N');
                yield from $this->getNeighboursInDirection($x, $y, 'S');
                break;
            default:
                throw new \RuntimeException('invalid direction');
        }
    }

    private function getNeighboursInDirection(int $x, int $y, string $direction): \Generator
    {
        $distance = 0;
        for ($i = 1; $i <= 3; $i++) {
            $x += self::DELTAS[$direction]['x'];
            $y += self::DELTAS[$direction]['y'];
            if (isset($this->map[$y][$x])) {
                $distance += $this->map[$y][$x];
                yield ['x' => $x, 'y' => $y, 'distance' => $distance, 'direction' => $direction];
            }
        }
    }

    public function walk(): void
    {
        while (true) {
            $current = $this->heap->extract();

            foreach ($this->getNeighbours($current['x'], $current['y'], $current['direction']) as $next) {
                $coord = $next['x'] . "," .  $next['y'];
#                $coordDir = $next['x'] . "," .  $next['y'] . "," . $next['direction'];
                if (isset($this->visited[$coord])) {  // && $this->visited[$coord]['direction'] === $next['direction']
                    continue;
                }
                $next['distance'] += $current['distance'];
                $this->heap->insert($next);
                $this->visited[$coord] = ['distance' => $next['distance'], 'direction' => $next['direction']];

                if ($coord === $this->finalCoord) {
                    return;
                }
            }
        }
    }

    public function getDistanceOfFinalTile(): int
    {
        return $this->visited[$this->finalCoord]['distance'];
    }
}

$solver = new Solver($in);

$solver->walk();

echo $solver->getDistanceOfFinalTile();


echo "\n", (microtime(true) - $start), "\n";
