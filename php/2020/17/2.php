<?php

$startTime = microtime(true);

$input = file(__DIR__ . '/in.txt');

$matrix = [[[[]]]];  // Z, Y, X !!!
ConwayCubes::$startX = ConwayCubes::$startY = 0 - floor(strlen(trim($input[0]))/2);
ConwayCubes::$startZ = ConwayCubes::$startW = 0;


// fill
foreach ($input as $posY => $row) {
    foreach(str_split(trim($row)) as $posX => $char) {
        $matrix[ConwayCubes::$startW][ConwayCubes::$startZ][ConwayCubes::$startY + $posY][ConwayCubes::$startX+$posX] = $char;
    }
}

class ConwayCubes {
    public static int $startX;
    public static int $startY;
    public static int $startZ;
    public static int $startW;

    public static function evolve(array $matrix): array
    {
        --self::$startW;
        --self::$startZ;
        --self::$startY;
        --self::$startX;
        $newMatrix = $matrix;
        for ($w = self::$startW; $w <= -1 * self::$startW; $w++) {
            for ($z = self::$startZ; $z <= -1 * self::$startZ; $z++) {
                for ($y = self::$startY; $y <= -1 * self::$startY; $y++) {
                    for ($x = self::$startX; $x <= -1 * self::$startX; $x++) {
                        $newMatrix[$w][$z][$y][$x] = self::newState($matrix, $x, $y, $z, $w);
                    }
                }
            }
        }

        return $newMatrix;
    }

    private static function newState(array $matrix, int $x, int $y, int $z, int $w): string
    {
        $own = $matrix[$w][$z][$y][$x] ?? '.';
        if ($own === '.') {
            if (self::findExactlyThree($matrix, $x, $y, $z, $w)) {
                return '#';
            }
            return '.';
        }
        if (self::findTwoOrThree($matrix, $x, $y, $z, $w)) {
            return '#';
        }
        return '.';
    }

    private static function findExactlyThree(array $matrix, int $x, int $y, int $z, int $w): bool
    {
        $count = 0;
        for ($iw = $w-1; $iw <= $w+1; $iw++) {
            for ($iz = $z - 1; $iz <= $z + 1; $iz++) {
                for ($iy = $y - 1; $iy <= $y + 1; $iy++) {
                    for ($ix = $x - 1; $ix <= $x + 1; $ix++) {
                        if ($ix === $x && $iy === $y && $iz === $z && $iw === $w) {
                            continue;
                        }
                        $char = $matrix[$iw][$iz][$iy][$ix] ?? '.';
                        if ('#' === $char) {
                            ++$count;
                        }
                    }

                    if ($count > 3) {
                        return false;
                    }
                }
            }
        }
        return $count === 3;
    }

    private static function findTwoOrThree(array $matrix, int $x, int $y, int $z, int $w): bool
    {
        $count = 0;
        for ($iw = $w-1; $iw <= $w+1; $iw++) {
            for ($iz = $z - 1; $iz <= $z + 1; $iz++) {
                for ($iy = $y - 1; $iy <= $y + 1; $iy++) {
                    for ($ix = $x - 1; $ix <= $x + 1; $ix++) {
                        if ($ix === $x && $iy === $y && $iz === $z && $iw === $w) {
                            continue;
                        }
                        $char = $matrix[$iw][$iz][$iy][$ix] ?? '.';
                        if ('#' === $char) {
                            ++$count;
                        }
                    }

                    if ($count > 3) {
                        return false;
                    }
                }
            }
        }
        return $count === 3 || $count === 2;
    }

    public static function out(array $matrix): void
    {
        foreach ($matrix as $pdi => $parallelDimension) {
            foreach ($parallelDimension as $di => $dimension) {
                echo "\n\nz=", $di, "\n";
                foreach ($dimension as $row) {
                    echo implode('', $row), "\n";
                }
            }
        }
    }

    public static function count($matrix): int
    {
        $str = '';
        foreach ($matrix as $pdi => $parallelDimension) {
            foreach ($parallelDimension as $di => $dimension) {
                foreach ($dimension as $row) {
                    $str .= implode('', $row);
                }
            }
        }
        $count = count_chars($str, 1);

        return $count[35];
    }
}


for ($gen = 1; $gen <= 6; $gen++) {
    $matrix = ConwayCubes::evolve($matrix);
}

echo ConwayCubes::count($matrix);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

