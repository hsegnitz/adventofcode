<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

class PathFinder {

    private array $found = [];

    public function __construct(
        private array $map = []
    ) {
    }

    public function traverse(int $y, int $x): void
    {
        if (isset($this->found["$y,$x"]) || !isset($this->map[$y][$x]) || $this->map[$y][$x] == 9) {
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
}



$map = [];
foreach ($input as $row) {
    $map[] = str_split(trim($row));
}


$lowPoints = [];
foreach ($map as $y => $row) {
    foreach ($row as $x => $cell) {
        $adjacent = [];
        if (isset($map[$y-1][$x])) {
            $adjacent[] = $map[$y-1][$x];
        }
        if (isset($row[$x-1])) {
            $adjacent[] = $row[$x-1];
        }
        if (isset($row[$x+1])) {
            $adjacent[] = $row[$x+1];
        }
        if (isset($map[$y+1][$x])) {
            $adjacent[] = $map[$y+1][$x];
        }

        $allLower = true;
        foreach ($adjacent as $adj) {
            if ($cell >= $adj) {
                $allLower = false;
                break;
            }
        }

        if ($allLower) {
            $lowPoints[] = [$y, $x];
        }
    }
}

$basinSizes = [];
foreach ($lowPoints as $lowPoint) {
    $pathFinder = new PathFinder($map);
    $pathFinder->traverse($lowPoint[0], $lowPoint[1]);
    $basinSizes[implode(',', $lowPoint)] = $pathFinder->getSize();
}

asort($basinSizes);

$largest = [];
for ($i = 0; $i < 3; $i++) {
    $largest[] = array_pop($basinSizes);
}

echo array_product($largest);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


