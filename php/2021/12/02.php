<?php

$startTime = microtime(true);

#$input = file('./example0.txt');
#$input = file('./example1.txt');
#$input = file('./example2.txt');
$input = file('./in.txt');

// strategy notes:
// there seems to be no LARGE-LARGE edge, so we basically can't get an endless loop


class segment
{
    private string $from;
    private string $to;

    public function __construct(string $input)
    {
        [$this->from, $this->to] = explode('-', trim($input));
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function __toString(): string
    {
        return "{$this->from}-{$this->to}";
    }
}

class solver
{
    private array $permutations = [];
    private array $map = [];

    /**
     * @param segment[] $edges
     */
    public function __construct(
        private array $edges
    ) {
        foreach ($edges as $edge) {
            if (!isset($this->map[$edge->getFrom()])) {
                $this->map[$edge->getFrom()] = [];
            }
            $this->map[$edge->getFrom()][$edge->getTo()] = $edge->getTo();

            if ($edge->getFrom() === 'start' || $edge->getTo() === 'end') {
                continue;
            }

            if (!isset($this->map[$edge->getTo()])) {
                $this->map[$edge->getTo()] = [];
            }
            $this->map[$edge->getTo()][$edge->getFrom()] = $edge->getFrom();
        }
    }

    public function solve(string $next = 'start', array $stack = []): void
    {
        if (self::isSmall($next) && self::customInArray($next, $stack)) {
            // this would be adding a small chamber a second time to the path and that is baaaaaad! :(
            return;
        }

        $stack[] = $next;

        // we finished the turn, kinda
        if ($next === 'end') {
            $this->permutations[] = implode(',', $stack);
            return;
        }

        foreach ($this->map[$next] as $further) {
            $this->solve($further, $stack);
        }
    }

    /*
     * Sooo....
     * We are allowed to visit one small location twice. But only one.
     */
    private static function customInArray(string $needle, array $haystack): bool
    {
        if ($needle === 'start' || $needle === 'end') {
            return in_array($needle, $haystack, true);
        }



        if (1 === max(array_values(array_count_values(array_filter($haystack, 'solver::isSmall'))))) {
            return false;
        }

        return in_array($needle, $haystack, true);
    }

    private static function isSmall(string $testee): bool
    {
        return ($testee === strtolower($testee));
    }

    public function getPermutations(): array
    {
        return $this->permutations;
    }
}

$edges = [];
foreach ($input as $line) {
    $edges[] = new segment($line);
}

$solver = new solver($edges);
$solver->solve();
echo count($solver->getPermutations());


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

