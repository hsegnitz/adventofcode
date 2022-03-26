<?php

namespace common;

class math {
    public static function greatestCommonDivisor(int $a, int $b): int
    {
        if ($a === 0 || $b === 0) {
            return $a + $b;
        }

        $max = max($a, $b);
        $min = min($a, $b);
        return self::greatestCommonDivisor($max % $min, $min);
    }

    public static function getSmallestCommonPrimeFactor(int $deltaCol, int $deltaLine): int
    {
        $absDeltaCol  = abs($deltaCol);
        $absDeltaLine = abs($deltaLine);
        if ($absDeltaCol === $absDeltaLine || $absDeltaCol === 0 || $absDeltaLine === 0) {
            return 1; // straight diagonals or horizontal/verticals
        }

        for ($i = 2; $i <= min($absDeltaCol, $absDeltaLine); $i++) {
            if ($absDeltaCol % $i === 0 && $absDeltaLine % $i === 0) {
                return $i;
            }
        }

        return -1;
    }
}
