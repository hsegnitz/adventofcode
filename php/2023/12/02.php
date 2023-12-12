<?php

namespace Year2023\Day12;

use common\ArrayKeyCache;

require_once __DIR__ . '/../../common/ArrayKeyCache.php';

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

class Arrangement {

    private static ?ArrayKeyCache $cache = null;

    private string $springs;
    private array $pattern;


    public function __construct(string $raw)
    {
        [$rawSprings, $rawPattern] = explode(" ", $raw);
        $this->springs = implode("?", array_fill(0, 5, $rawSprings));
        $rawPattern = implode(",", array_fill(0, 5, $rawPattern));
        $this->pattern = explode(",", $rawPattern);
        array_walk($this->pattern, static function (&$value) {$value = (int)$value;});
        if (null === self::$cache) {
            self::$cache = new ArrayKeyCache();
        }
    }

    public function getCountOfValidPermutations(): int
    {
        return $this->permutateAndCountCacheWrapper($this->springs, $this->pattern);
    }

    private function permutateAndCountCacheWrapper(string $springs, array $pattern): int
    {
        $key = $pattern;
        $key[] = $springs;
        if (null === ($result = self::$cache->retrieve($key))) {
            $result = $this->permutateAndCount($springs, $pattern);
            self::$cache->store($key, $result);
        }
        return $result;
    }

    private function permutateAndCount(string $springs, array $pattern): int
    {
        #empty string AND pattern means we are at the end and have found a match
        if ($springs === '') {
            if ($pattern === []) {
                return 1;
            }
            return 0;   // some leftover pattern -> can't fulfill
        }

        # if there is no pattern left, and also no springs, return a match
        if ($pattern === []) {
            if (str_contains($springs, "#")) {
                return 0;  // still some left, no match.
            }
            return 1;
        }

        # early exit if the remainder cannot work
        # if the sum of the pattern plus the minimum number of separators is longer than the remainder of the string
        # return 0, no match
        if ((array_sum($pattern) + count($pattern)-1) > strlen($springs)) {
            return 0;
        }

        # now, if there is only one pattern left, the string is the same length AND does not contain a separator, we found a match
        # the wildcard does not matter, it can only work when it's a #, so we can skip permutations.
        if (count($pattern) === 1 && $pattern[0] === strlen($springs) && !str_contains($springs, '.')) {
            return 1;
        }

        $count = 0;
        # if the next one is not a broken fountain - or is a wildcard - we move on with just a shorter string
        if ($springs[0] !== '#') {
            $count += $this->permutateAndCountCacheWrapper(substr($springs, 1), $pattern);
        }

        # if there is a block exactly the size of the next pattern that does not contain a separator, we recurse on
        # (but not count, we're not at the end yet!)
        $nextPattern = array_shift($pattern);
        $sub = substr($springs, 0, $nextPattern);
        $next = '';
        if (strlen($springs) > $nextPattern) {
            $next = $springs[$nextPattern];  //  0 indexed ftw!
        }

        if ($next !== '#' && !str_contains($sub, '.')) {
            $count += $this->permutateAndCountCacheWrapper(substr($springs, $nextPattern + 1), $pattern);
        }

        return $count;
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

