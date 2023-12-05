<?php

namespace Year2023\Day05;

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

        usort($this->ranges, function (Range $a, Range $b) {
            return $a->getLower() <=> $b->getLower();
        });
    }

    /**
     * @param SeedRange[] $in
     * @return SeedRange[]
     */
    public function convert(array $in): array
    {
        $remainder = $in;
        $out = [];
        foreach ($this->ranges as $range) {
            $newRemainder = [];
            foreach ($remainder as $seedRange) {
                $res = $range->intersectAndTranspose($seedRange);
                if ($res === [$seedRange]) {   // no hit
                    if ($seedRange->upper < $range->getLower()) { // on lower side
                        $out[] = $res[0];
                        continue;
                    }
                    // requeue
                    $newRemainder[] = $seedRange;
                    continue;
                }
                if (count($res) === 1) {  // full hit
                    $out[] = $res[0];
                    continue;
                }
                if (count($res) === 3) {  // inner hit -- first is a no-transform but won't hit a later one, second is the transform hit
                    $out[] = $res[0];
                    $out[] = $res[1];
                    // third might match another
                    $newRemainder[] = $res[2];
                }
                if (count($res) === 2) {
                    $out[] = $res[0];
                    if ($res[0]->upper === $range->getLower()) {
                        $out[] = $res[1];
                    } else {
                        $newRemainder[] = $res[1];
                    }
                }
            }
            $remainder = $newRemainder;
        }

        // leftovers that were AFTER all specified ranges
        foreach ($remainder as $remain) {
            $out[] = $remain;
        }

        return array_unique($out);
    }
}

class Range
{
    private int $destination;
    private int $source;
    private int $length;

    private int $inLower;
    private int $inUpper;
    private int $transformation;

    private array $rest = [];

    public function __construct(string $input)
    {
        [$this->destination, $this->source, $this->length] = explode(" ", $input);
        $this->inLower = $this->source;
        $this->inUpper = $this->source + $this->length - 1;
        $this->transformation = $this->destination - $this->source;
    }

    /**
     * @param SeedRange $in
     * @return SeedRange[]
     */
    public function intersectAndTranspose(SeedRange $in): array
    {
        if ($in->upper < $this->inLower || $in->lower > $this->inUpper) {
            return [$in];
        }

        $ret = [];
        if ($in->lower < $this->inLower) {
            $ret[] = new SeedRange($in->lower, $this->inLower-1);
        }

        $ret[] = new SeedRange(
            max($in->lower, $this->inLower) + $this->transformation,
            min($in->upper, $this->inUpper) + $this->transformation
        );

        if ($in->upper > $this->inUpper) {
            $ret[] = new SeedRange($this->inUpper + 1, $in->upper);
        }

        return $ret;
    }

    public function getRest(): array
    {
        return $this->rest;
    }

    public function getLower(): int
    {
        return $this->inLower;
    }
}

readonly class SeedRange
{
    public function __construct(public readonly int $lower, public readonly int $upper)
    {}

    public function __toString(): string
    {
        return $this->lower . ':' . $this->upper;
    }
}

