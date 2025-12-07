<?php

$start = microtime(true);

#$lines = file_get_contents('example.txt');
$lines = file_get_contents('input.txt');

[$rawRanges, $numbers] = explode("\n\n", $lines);

$ranges = [];
foreach (explode("\n", $rawRanges) as $range) {
    $ranges[] = new Range($range);
}

# Strategy:
# 1. merge ranges: loop over all ranges and a new .
#    If lower AND higher is part of another, discard
#    If lower is within a previous range, replace it with a new one, making it old-lower to new higher
#    If higher is within a previous range, replace it with a new one, making it new-lower to old higher

usort($ranges, function ($a, $b) {
    return $a->lower <=> $b->lower;
});

$changed = true;
while ($changed) {
    $changed = false;
    $newRanges = [];
    foreach ($ranges as $range) {
        foreach ($newRanges as $newKey => $newRange) {
            $lowerIsInRange = $newRange->isInRange($range->lower);
            $higherIsInRange = $newRange->isInRange($range->upper);
            if ($lowerIsInRange && $higherIsInRange) {
                echo "i";
                $changed = true;
                continue 2;
            }
            if ($lowerIsInRange) {
                echo "l";
                $newRanges[$newKey] = new Range($newRange->lower . '-' . $range->upper);
                $changed = true;
                continue 2;
            }
            if ($higherIsInRange) {
                echo "h";
                $newRanges[$newKey] = new Range($range->lower . '-' . $newRange->upper);
                $changed = true;
                continue 2;
            }
            echo ".";
        }
        $newRanges[] = $range;
    }
    $ranges = $newRanges;
}

echo "\n";

print_r($ranges);

$sum = 0;

foreach ($ranges as $range) {
    $sum += $range->getSize() + 1;
}

echo "\n", $sum, "\n";


class Range
{
    public int $lower;
    public int $upper;
    public function __construct(string $input)
    {
        [$this->lower, $this->upper] = explode("-", $input);
    }

    public function isInRange(int $number): bool
    {
        return $number >= $this->lower && $number <= $this->upper;
    }

    public function getSize(): int
    {
        return $this->upper - $this->lower;
    }
}
