<?php

namespace Year2023\Day12;

use common\math;

require_once __DIR__ . '/../../common/math.php';

$start = microtime(true);

$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

class Arrangement {

    private array $springs;
    private array $pattern;
    private array $permutations;

    public function __construct(string $raw)
    {
        [$rawSprings, $rawPattern] = explode(" ", $raw);
        $this->springs = str_split($rawSprings);
        $this->pattern = explode(",", $rawPattern);
        array_walk($this->pattern, static function (&$value) {$value = (int)$value;});
    }

    private function isValid(array $permutation): bool
    {
        $p = implode("", $permutation);
        $p2 = trim($p, ".");
        $p3 = preg_split('/\.+/', $p2);
        $counts = [];
        foreach ($p3 as $block) {
            $counts[] = strlen($block);
        }

        return $counts === $this->pattern;
    }

    private function permutate(): void
    {
        $this->permutations[] = $this->springs;
    }

    public function getCountOfValidPermutations(): int
    {
        $this->permutate();

        $validCount = 0;
        foreach ($this->permutations as $permutation) {
            if ($this->isValid($permutation)) {
                ++$validCount;
            }
        }
        return $validCount;
    }
}

foreach ($lines as $line) {
    $arrangement = new Arrangement($line);
    echo $line, ": ", $arrangement->getCountOfValidPermutations(), "\n";
}


echo "\n";

echo microtime(true) - $start;
echo "\n";

