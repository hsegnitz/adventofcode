<?php

$startTime = microtime(true);

enum Orientation: string {
    case U = "U";
    case D = "D";
    case L = "L";
    case R = "R";
}

class Direction {
    private Orientation $direction;
    private int $length;

    public function __construct(string $raw) {
        $this->direction = Orientation::from($raw[0]);
        $this->length = (int)substr($raw, 1);
    }

    public function getDirection(): Orientation
    {
        return $this->direction;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}

class Path
{
    private array $directions = [];
    private array $occupiedCoordinates = [];

    public function __construct(string $rawInput)
    {
        foreach (explode(',', $rawInput) as $direction) {
            $this->directions[] = new Direction($direction);
        }
        $this->walk();
    }

    private function walk(): void
    {
        $x = $y = 0;
        foreach ($this->directions as $a) {
            if ($a->getDirection() === Orientation::R) {
                for ($i = 0; $i < $a->getLength(); $i++) {
                    $this->occupiedCoordinates[(++$x . 'x' . $y)] = true;
                }
            }
            if ($a->getDirection() === Orientation::L) {
                for ($i = 0; $i < $a->getLength(); $i++) {
                    $this->occupiedCoordinates[(--$x . 'x' . $y)] = true;
                }
            }
            if ($a->getDirection() === Orientation::U) {
                for ($i = 0; $i < $a->getLength(); $i++) {
                    $this->occupiedCoordinates[($x . 'x' . ++$y)] = true;
                }
            }
            if ($a->getDirection() === Orientation::D) {
                for ($i = 0; $i < $a->getLength(); $i++) {
                    $this->occupiedCoordinates[($x . 'x' . --$y)] = true;
                }
            }
        }
    }

    public function getOccupiedCoordinates(): array
    {
        return $this->occupiedCoordinates;
    }
}

$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$a = new Path($input[0]);
$b = new Path($input[1]);

$intersection = array_intersect_assoc($a->getOccupiedCoordinates(), $b->getOccupiedCoordinates());

$distances = [];
foreach (array_keys($intersection) as $coordinatePair) {
    $xxx = explode('x', $coordinatePair);
    $distances[] = abs($xxx[0]) + abs($xxx[1]);
}

echo min($distances);

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
