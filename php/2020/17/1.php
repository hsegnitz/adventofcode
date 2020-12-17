<?php

$startTime = microtime(true);

$input = file(__DIR__ . '/in.txt');

$matrix = [[[]]];  // Z, Y, X !!!
ConwayCubes::$startX = ConwayCubes::$startY = 0 - floor(strlen(trim($input[0]))/2);
ConwayCubes::$startZ = 0;

// fill
foreach ($input as $posY => $row) {
    foreach(str_split(trim($row)) as $posX => $char) {
        $matrix[ConwayCubes::$startZ][ConwayCubes::$startY + $posY][ConwayCubes::$startX+$posX] = $char;
    }
}

class ConwayCubes {
    public static int $startX;
    public static int $startY;
    public static int $startZ;

    public static function evolve(array $matrix): array
    {
        --self::$startZ;
        --self::$startY;
        --self::$startX;
        $newMatrix = $matrix;
        for ($z = self::$startZ; $z <= -1 * self::$startZ; $z++) {
            for ($y = self::$startY; $y <= -1 * self::$startY; $y++) {
                for ($x = self::$startX; $x <= -1 * self::$startX; $x++) {
                    $newMatrix[$z][$y][$x] = self::newState($matrix, $x, $y, $z);
                }
            }
        }

        return $newMatrix;
    }

    private static function newState(array $matrix, int $x, int $y, int $z): string
    {
        $own = $matrix[$z][$y][$x] ?? '.';
        if ($own === '.') {
            if (self::findExactlyThree($matrix, $x, $y, $z)) {
                return '#';
            }
            return '.';
        }
        if (self::findTwoOrThree($matrix, $x, $y, $z)) {
            return '#';
        }
        return '.';
    }

    private static function findExactlyThree(array $matrix, int $x, int $y, int $z): bool
    {
        $count = 0;
        for ($iz = $z-1; $iz <= $z+1; $iz++) {
            for ($iy = $y-1; $iy <= $y+1; $iy++) {
                for ($ix = $x-1; $ix <= $x+1; $ix++) {
                    if ($ix === $x && $iy === $y && $iz === $z) {
                        continue;
                    }
                    $char = $matrix[$iz][$iy][$ix] ?? '.';
                    if ('#' === $char) {
                        ++$count;
                    }
                }

                if ($count > 3) {
                    return false;
                }
            }
        }

        return $count === 3;
    }

    private static function findTwoOrThree(array $matrix, int $x, int $y, int $z): bool
    {
        $count = 0;
        for ($iz = $z-1; $iz <= $z+1; $iz++) {
            for ($iy = $y-1; $iy <= $y+1; $iy++) {
                for ($ix = $x-1; $ix <= $x+1; $ix++) {
                    if ($ix === $x && $iy === $y && $iz === $z) {
                        continue;
                    }
                    $char = $matrix[$iz][$iy][$ix] ?? '.';
                    if ('#' === $char) {
                        ++$count;
                    }
                }

                if ($count > 3) {
                    return false;
                }
            }
        }

        return $count === 3 || $count === 2;
    }

    public static function out(array $matrix): void
    {
        foreach ($matrix as $di => $dimension) {
            echo "\n\nz=", $di, "\n";
            foreach ($dimension as $row) {
                echo implode('', $row), "\n";
            }
        }

    }

    public static function count($matrix): int
    {
        $str = '';
        foreach ($matrix as $dimension) {
            foreach ($dimension as $row) {
                $str .= implode('', $row);
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

