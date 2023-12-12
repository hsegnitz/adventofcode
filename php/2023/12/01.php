<?php

namespace Year2023\Day12;

use common\math;

require_once __DIR__ . '/../../common/math.php';

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

class Arrangement {

    private array $springs;
    private array $pattern;


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

    private function getPermutationsOf(array $springs): \Generator
    {
        if (false !== ($pos = array_search('?', $springs, true))) {
            $springs[$pos] = '.';
            yield from $this->getPermutationsOf($springs);
            $springs[$pos] = '#';
            yield from $this->getPermutationsOf($springs);
        } else {
            yield $springs;
        }
    }

    public function getCountOfValidPermutations(): int
    {
        $validCount = 0;
        foreach ($this->getPermutationsOf($this->springs) as $permutation) {
#            echo "    ", implode("", $permutation), "\n";
            if ($this->isValid($permutation)) {
                ++$validCount;
            }
        }
        return $validCount;
    }
}

$sum = 0;
foreach ($lines as $line) {
    $arrangement = new Arrangement($line);
    echo $line, ": ", ($count = $arrangement->getCountOfValidPermutations()), "\n";
    $sum += $count;
}


echo "\n", $sum, "\n";

echo microtime(true) - $start;
echo "\n";

