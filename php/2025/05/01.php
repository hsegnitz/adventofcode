<?php

$start = microtime(true);

#$lines = file_get_contents('example.txt');
$lines = file_get_contents('input.txt');

[$rawRanges, $numbers] = explode("\n\n", $lines);

$ranges = [];
foreach (explode("\n", $rawRanges) as $range) {
    $ranges[] = new Range($range);
}

$count = 0;
foreach (explode("\n", $numbers) as $number) {
    foreach ($ranges as $range) {
        if ($range->isInRange($number)) {
           ++$count;
           continue 2;
        }
    }
}

echo "\n\n", $count, "\n";

class Range
{
    private int $lower;
    private int $upper;
    public function __construct(string $input)
    {
        [$this->lower, $this->upper] = explode("-", $input);
    }

    public function isInRange(int $number): bool
    {
        return $number >= $this->lower && $number <= $this->upper;
    }
}

