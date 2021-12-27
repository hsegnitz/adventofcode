<?php

use Y2017\D10\KnotHash;

$startTime = microtime(true);

require_once '../10/KnotHash.php';

#$input = 'flqrgnkx';
$input = 'hxtvlmkl';

$map = [];
for ($i = 0; $i < 128; $i++) {
    $map[$i] = [];
    foreach (str_split((new KnotHash())->hashBinary($input . '-' . $i)) as $index => $content) {
        $map[$i][] = '1' === $content ? '#' : '.';
    }
}

class PathFinder {

    private array $found = [];

    public function __construct(
        private array $map = []
    ) {}

    public function traverse(int $y, int $x): void
    {
        if (isset($this->found["$y,$x"]) || !isset($this->map[$y][$x]) || $this->map[$y][$x] === '.') {
            return;
        }

        $this->found["$y,$x"] = true;

        $this->traverse($y+1, $x);
        $this->traverse($y-1, $x);
        $this->traverse($y, $x-1);
        $this->traverse($y, $x+1);
    }

    public function getSize(): int
    {
        return count($this->found);
    }

    public function getMapWithoutFoundTiles(): array
    {
        $newMap = $this->map;
        foreach (array_keys($this->found) as $coord) {
            [$y, $x] = explode(',', $coord);
            $newMap[$y][$x] = '.';
        }
        return $newMap;
    }
}

$count = 0;

for ($rowNum = 0; $rowNum < 128; $rowNum++) {
    for ($colNum = 0; $colNum < 128; $colNum++) {
        if ($map[$rowNum][$colNum] === '.') {
            continue;
        }
        $pathFinder = new PathFinder($map);
        $pathFinder->traverse($rowNum, $colNum);
        ++$count;
        $map = $pathFinder->getMapWithoutFoundTiles();
    }
}

echo $count;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
