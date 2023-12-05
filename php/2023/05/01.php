<?php

namespace Year2023\Day05\Part1;

#$input = file_get_contents('example.txt');
$input = file_get_contents('input.txt');

class Map
{
    /** @var Range[] */
    private array $ranges = [];
    public function __construct(string $input)
    {
        $lines = explode("\n", $input);
        array_shift($lines);
        foreach ($lines as $line) {
            $this->ranges[] = new Range($line);
        }
    }

    public function convert(int $in): int
    {
        foreach ($this->ranges as $range) {
            if (null !== ($result = $range->convert($in))) {
                return $result;
            }
        }
        return $in;
    }
}

class Range
{
    private int $destination;
    private int $source;
    private int $length;
    public function __construct(string $input)
    {
        [$this->destination, $this->source, $this->length] = explode(" ", $input);
    }

    public function convert(int $in): ?int
    {
        if ($in >= $this->source && $in <= $this->source + $this->length) {
            return $in - ($this->source - $this->destination);
        }
        return null;
    }
}



$blocks = explode("\n\n", $input);
$seeds = explode(" ", array_shift($blocks));
array_shift($seeds);

$maps = [];
foreach ($blocks as $block) {
    $maps[] = new Map($block);
}

$locations = [];
foreach ($seeds as $seed) {
    $location = $seed;
    foreach ($maps as $map) {
        $location = $map->convert($location);
    }

    $locations[] = $location;
    echo $seed, " -> ", $location, "\n";
}

echo "lowest: ", min($locations);

echo "\n";


