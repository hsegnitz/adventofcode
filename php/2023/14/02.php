<?php

namespace Year2023\Day14;

$start = microtime(true);

#$in = file_get_contents('example.txt');
$in = file_get_contents('input.txt');

class Map {
    private array $map = [];

    public function __construct(string $raw)
    {
        foreach (explode("\n", trim($raw)) as $line) {
            $this->map[] = str_split($line);
        }
    }

    private function rollNorth(): void
    {
        foreach ($this->map as $y => $row) {
            if ($y === 0) {
                continue;
            }
            foreach ($row as $x => $cell) {
                if ($cell !== 'O') {
                    continue;
                }

                $this->map[$y][$x] = '.';
                $newY = $y;
                while($newY > 0 && $this->map[$newY-1][$x] === '.') {
                    --$newY;
                }
                $this->map[$newY][$x] = 'O';
            }
        }
    }

    private function rollWest(): void
    {
        for ($x = 1, $maxX = count($this->map[0]); $x < $maxX; $x++) {
            for ($y = 0, $maxY = count($this->map); $y < $maxY; $y++) {
                if ($this->map[$y][$x] !== 'O') {
                    continue;
                }

                $this->map[$y][$x] = '.';
                $newX = $x;
                while($newX > 0 && $this->map[$y][$newX-1] === '.') {
                    --$newX;
                }
                $this->map[$y][$newX] = 'O';
            }
        }
    }

    private function rollSouth(): void
    {
        for ($y = count($this->map)-1; $y >= 0; $y--) {
            for ($x = 0, $maxX = count($this->map[0]); $x < $maxX; $x++) {
                if ($this->map[$y][$x] !== 'O') {
                    continue;
                }

                $this->map[$y][$x] = '.';
                $newY = $y;
                while($newY < count($this->map)-1 && $this->map[$newY+1][$x] === '.') {
                    ++$newY;
                }
                $this->map[$newY][$x] = 'O';
            }
        }
    }

    private function rollEast(): void
    {
        for ($x = count($this->map[0])-1; $x >=0; $x--) {
            for ($y = 0, $maxY = count($this->map); $y < $maxY; $y++) {
                if ($this->map[$y][$x] !== 'O') {
                    continue;
                }

                $this->map[$y][$x] = '.';
                $newX = $x;
                while($newX < count($this->map[0])-1 && $this->map[$y][$newX+1] === '.') {
                    ++$newX;
                }
                $this->map[$y][$newX] = 'O';
            }
        }
    }

    public function cycle(): void
    {
        $this->rollNorth();
        $this->rollWest();
        $this->rollSouth();
        $this->rollEast();
    }

    public function getTotalWeight(): int
    {
        $sum = 0;
        $revRows = array_reverse($this->map);
        foreach ($revRows as $rowNum => $row) {
            $sum += (array_count_values($row)["O"] ?? 0) * ($rowNum+1);
        }

        return $sum;
    }

    public function __toString(): string
    {
        $temp = [];
        foreach ($this->map as $row) {
            $temp[] = implode("", $row);
        }
        return implode("\n", $temp);
    }
}

$map = new Map($in);
$hashMap = [];
$weights = [];
$first = 0;

for ($cycle = 1; $cycle < 1000000000; $cycle++) {
    $map->cycle();
    $hash = (string)$map;
    if (isset($hashMap[$hash])) {
        $first = $hashMap[$hash];
        break;
    }
    $hashMap[$hash] = $cycle;
    $weights[$cycle] = $map->getTotalWeight();
}

echo $first, "\n", $cycle, "\n";

$indexAtEnd = (1000000000 - $first) % ($cycle - $first) + $first;


echo "\n", $weights[$indexAtEnd], "\n";


echo microtime(true) - $start;
echo "\n";

