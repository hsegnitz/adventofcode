<?php

$startTime = microtime(true);

$input = file_get_contents('./example.txt');
#$input = file_get_contents('./in.txt');

$rows = explode("\n", $input);

$map = [];
foreach ($rows as $row) {
    $map[] = str_split(trim($row));
}

function getNeighbours(int $x, int $y, $map): array
{
    $neighbours = [];
    if (isset($map[$y-1][$x])) {
        $neighbours[] = $map[$y-1][$x];
    }
    if (isset($map[$y][$x-1])) {
        $neighbours[] = $map[$y][$x-1];
    }
    if (isset($map[$y][$x+1])) {
        $neighbours[] = $map[$y][$x+1];
    }
    if (isset($map[$y+1][$x])) {
        $neighbours[] = $map[$y+1][$x];
    }
    return $neighbours;
}

class AdventOfHeap extends SplMinHeap
{
    protected function compare(mixed $value1, mixed $value2): int
    {
        return $value2['distance'] - $value1['distance'];
    }
}

$visited = [];
$heap = new AdventOfHeap();
$heap->insert(['x' => 0, 'y' => 0, 'distance' => 0]);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

