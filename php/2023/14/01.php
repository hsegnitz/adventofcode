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

    public function rollNorth(): void
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

    public function getTotalWeight(): int
    {
        $sum = 0;
        $revRows = array_reverse($this->map);
        foreach ($revRows as $rowNum => $row) {
            $sum += (array_count_values($row)["O"] ?? 0) * ($rowNum+1);
        }

        return $sum;
    }
}

$map = new Map($in);
$map->rollNorth();


echo "\n", $map->getTotalWeight(), "\n";


echo microtime(true) - $start;
echo "\n";

