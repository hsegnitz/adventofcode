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

    public static function taxiDistance(int $startX, int $endX, int $startY, int $endY, int $startZ = 0, int $endZ = 0): int
    {
        return abs($endX - $startX) + abs($endY - $startY) + abs($endZ - $startZ);
    }

    public static function leastCommonMultiple(int $x, int ...$moreVars): int {
        $lcm = $x;
        foreach ($moreVars as $anotherVar) {
            $lcm = ($lcm * $anotherVar) / self::greatestCommonDivisor($lcm, $anotherVar);
        }
        return $lcm;
    }

    public static function taxiDelta(int $startX, int $endX, ?int $startY = null, ?int $endY = null, ?int $startZ = null, ?int $endZ = null): array
    {
        $ret = [
            $endX - $startX,
        ];
        if ($startY !== null && $endY !== null) {
            $ret[] = $endY - $startY;
        }
        if ($startZ !== null && $endZ !== null) {
            $ret[] = $endZ - $startZ;
        }
        return $ret;
    }

    public static function integerDivisors(int $number): \Generator
    {
        for ($i = 1; $i <= ceil($number/2); $i++) {
            if ($number % $i === 0) {
                yield $i;
            }
        }
    }
}
