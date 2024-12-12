<?php

use common\ArrayKeyCache;

$start = microtime(true);

require_once '../../common/ArrayKeyCache.php';

#$rawMap  = file('example.txt', FILE_IGNORE_NEW_LINES);
#$rawMap  = file('example2.txt', FILE_IGNORE_NEW_LINES);
#$rawMap  = file('example3.txt', FILE_IGNORE_NEW_LINES);
$rawMap  = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = [];
foreach ($rawMap as $row) {
    $map[] = str_split($row);
}

class region {
    private ArrayKeyCache $plots;
    private ArrayKeyCache $neighbors;
    private string $plant;
    public function __construct(private array $map) {
        $this->plots = new ArrayKeyCache('x');
        $this->neighbors = new ArrayKeyCache('x');
    }

    public function fill(int $startRow, int $startCol): array
    {
        if ($this->map[$startRow][$startCol] === '#') {
            throw new \RuntimeException('this field has been already used');
        }
        $this->plant = $this->map[$startRow][$startCol];
        $this->walk($startRow, $startCol);

        foreach ($this->plots->getKeyIterator() as $key) {
            [$row, $col] = explode('x', $key);
            $this->map[$row][$col] = '#';
        }
        return $this->map;
    }

    private function walk(int $nextRow, int $nextCol): void
    {
        if ($this->plots->has([$nextRow, $nextCol]) || $this->neighbors->has([$nextRow, $nextCol])) {
            return;
        }
        if (isset($this->map[$nextRow][$nextCol]) && $this->map[$nextRow][$nextCol] === $this->plant) {
            $this->plots->store([$nextRow, $nextCol], true);
            $this->walk($nextRow-1, $nextCol);
            $this->walk($nextRow+1, $nextCol);
            $this->walk($nextRow, $nextCol-1);
            $this->walk($nextRow, $nextCol+1);
        } else {
            $this->neighbors->store([$nextRow, $nextCol], true);
        }
    }

    public function getPrice(): int
    {
        return count($this->plots) * $this->fenceSegments();
    }

    private function fenceSegments(): int
    {
        $count = 0;
        foreach ($this->neighbors->getKeyIterator() as $key) {
            [$row, $col] = explode('x', $key);
            $row = (int)$row;
            $col = (int)$col;
            if ($this->plots->has([$row+1, $col])) $count++;
            if ($this->plots->has([$row-1, $col])) $count++;
            if ($this->plots->has([$row, $col+1])) $count++;
            if ($this->plots->has([$row, $col-1])) $count++;
        }
        return $count;
    }
}

function findCoordsOfUnregisteredPlot(array $map): ?array
{
    foreach ($map as $rowNum => $row) {
        foreach ($row as $colNum => $cell) {
            if ($cell !== '#') {
                return [$rowNum, $colNum];
            }
        }
    }
    return null;
}

$sum = 0;
while (null !== ($coords = findCoordsOfUnregisteredPlot($map))) {
    [$row, $col] = $coords;
    $region = new region($map);
    $map = $region->fill($row, $col);
    $sum += $region->getPrice();
}

echo $sum, "\n";


echo microtime(true) - $start;
echo "\n";
