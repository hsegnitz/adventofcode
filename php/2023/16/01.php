<?php

namespace Year2023\Day16;

$start = microtime(true);

#$in = file('example.txt', FILE_IGNORE_NEW_LINES);
$in = file('input.txt', FILE_IGNORE_NEW_LINES);

$mirrorMap = [];
foreach ($in as $line) {
    $mirrorMap[] = str_split($line);
}

class BeamTracer {
    private array $seenCoords = [];
    private array $seenCoordAndDirections = [];
    public function __construct(private readonly array $mirrorMap)
    {}

    public function trace(int $x, int $y, string $direction): void
    {
        do {
            $cKey = "$x-$y";
            $this->seenCoords[$cKey] = true;
            $cdKey = "$x-$y-$direction";
            if (isset($this->seenCoordAndDirections[$cdKey])) {
                return;  // loop detected
            }
            $this->seenCoordAndDirections[$cdKey] = true;

            [$x, $y] = $this->walk($x, $y, $direction);
            if (!isset($this->mirrorMap[$y][$x])) {
                return;
            }
            $tile = $this->mirrorMap[$y][$x];
            if ($tile === ".") {
                continue;
            }

            if ($tile === '/') {
                $direction = match($direction) {
                    "R" => 'U',
                    "L" => 'D',
                    "U" => 'R',
                    "D" => 'L',
                };
                continue;
            }

            if ($tile === '\\') {
                $direction = match($direction) {
                    "R" => 'D',
                    "L" => 'U',
                    "U" => 'L',
                    "D" => 'R',
                };
                continue;
            }

            if ($tile === '-') {
                if ($direction === 'D' || $direction === 'U') {
                    $this->trace($x, $y, 'L');
                    $this->trace($x, $y, 'R');
                    return;
                }
                continue;
            }

            if ($tile === '|') {
                if ($direction === 'L' || $direction === 'R') {
                    $this->trace($x, $y, 'U');
                    $this->trace($x, $y, 'D');
                    return;
                }
                continue;
            }

        } while (isset($this->mirrorMap[$y][$x]));
    }


    private function walk (int $x, int $y, string $direction): array
    {
        return match ($direction) {
            "R" => [$x+1, $y],
            "L" => [$x-1, $y],
            "U" => [$x,   $y-1],
            "D" => [$x,   $y+1],
        };
    }

    public function countCoords(): int
    {
        return count($this->seenCoords)-1; // the initial tile is out of the map!
    }

    public function printMap(): void
    {
        foreach ($this->mirrorMap as $y => $row) {
            foreach ($row as $x => $cell) {
                if (isset($this->seenCoords["$x-$y"])) {
                    echo "#";
                } else {
                    echo ".";
                }
            }
            echo "\n";
        }
        echo "\n";
    }
}

$tracer = new BeamTracer($mirrorMap);
$tracer->trace(-1, 0, 'R');

echo "\nPart 1:", $tracer->countCoords(), "\n";

$results = [];
for ($y = 0, $yMax = count($mirrorMap); $y < $yMax; $y++) {
    $tracer = new BeamTracer($mirrorMap);
    $tracer->trace(-1, $y, 'R');
    $results[] = $tracer->countCoords();

    $tracer = new BeamTracer($mirrorMap);
    $tracer->trace(count($mirrorMap[$y]), $y, 'L');
    $results[] = $tracer->countCoords();
}

for ($x = 0, $xMax = count($mirrorMap[0]); $x < $xMax; $x++) {
    $tracer = new BeamTracer($mirrorMap);
    $tracer->trace($x, -1, 'D');
    $results[] = $tracer->countCoords();

    $tracer = new BeamTracer($mirrorMap);
    $tracer->trace($x, count($mirrorMap), 'U');
    $results[] = $tracer->countCoords();
}

echo "Part2: ", max($results), "\n";

echo microtime(true) - $start;
echo "\n";

