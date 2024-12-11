<?php

$startTime = microtime(true);

$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./in.txt', FILE_IGNORE_NEW_LINES);


class Map {
    /** @var string[] */
    private array $map = ['500x0' => '+'];
    private int $minX = 500;
    private int $maxX = 500;
    private int $minY = 0;
    private int $maxY = 0;
    public int $sandCount = 0;

    public function __construct(array $inputLines) {
        foreach ($inputLines as $line) {
            $this->drawRock($line);
        }

        # okay, #easyhack: the "infinite line" would be "height" pixels to the left and right of the sand entry point -- adding another 5 for good measure.

        $y = $this->maxY + 2;
        $lastLine = (500-$y-5) . ',' . $y . ' -> ' . (500+$y+5) . ',' . $y;
        $this->drawRock($lastLine);
    }
    private function drawRock(string $line): void {
        $coords = [];
        foreach (explode (' -> ', $line) as $rawCoord) {
            $coords[] = explode(',', $rawCoord);
        }

        $current = array_shift($coords);
        foreach ($coords as $coord) {
            $this->minX = min($this->minX, $coord[0], $current[0]);
            $this->maxX = max($this->maxX, $coord[0], $current[0]);
#            $this->minY = min($this->minY, $coord[1]);
            $this->maxY = max($this->maxY, $coord[1], $current[1]);
            if ($current[0] === $coord[0]) {  #vertical
                $x = $current[0];
                foreach (range(min($current[1], $coord[1]), max($current[1], $coord[1])) as $y) {
                    $this->map["{$x}x{$y}"] = '#';
                }
            } else if ($current[1] === $coord[1]) {  #horizontal
                $y = $current[1];
                foreach (range(min($current[0], $coord[0]), max($current[0], $coord[0])) as $x) {
                    $this->map["{$x}x{$y}"] = '#';
                }
            } else {
                throw new RuntimeException('huh?');
            }
            $current = $coord;
        }
    }

    public function visualize(): void {
        for ($y = $this->minY; $y <= $this->maxY; $y++) {
            for ($x = $this->minX; $x <= $this->maxX; $x++) {
                echo $this->map["{$x}x{$y}"] ?? '.';
            }
            echo "\n";
        }
    }

    public function sand(): bool {
        $this->sandCount++;
        $x = 500;
        $y = 0;

        while ($y < $this->maxY) {
            $testY  = $y + 1;
            $testX1 = $x + 1;
            $testX2 = $x - 1;
            if (!isset($this->map["{$x}x{$testY}"])) {
                $y = $testY;
            } elseif (!isset($this->map["{$testX2}x{$testY}"])) {
                $x = $testX2;
                $y = $testY;
            } elseif (!isset($this->map["{$testX1}x{$testY}"])) {
                $x = $testX1;
                $y = $testY;
            } else {
                $this->map["{$x}x{$y}"] = 'o';
                return !($x === 500 && $y === 0);
            }
        }
        return false;
    }
}

$map = new Map($input);
while ($map->sand()) {
    #work
}
$map->visualize();





echo "Part 2: ", $map->sandCount;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

