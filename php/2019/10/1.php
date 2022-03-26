<?php

$startTime = microtime(true);

require_once __DIR__ . '/../../common/math.php';

class Solver {

    private array $map = [];

    public function __construct()
    {
        $this->readMap();
        $this->printMap();

        $maxSeen = 0;

        $asteroidsSeen2 = $this->countVisibleAsteroids(13, 11);
        echo "manual input: ", $asteroidsSeen2, "\n";

/*  */
        //iterate over all points
        for ($candidateLine = 0, $candidateLineMax = count($this->map); $candidateLine < $candidateLineMax; $candidateLine++) {
            for ($candidateCol = 0, $candidateColMax = count($this->map); $candidateCol < $candidateColMax; $candidateCol++) {
                if ($this->map[$candidateLine][$candidateCol] !== '#') {
                    continue;
                }
                $asteroidsSeen = $this->countVisibleAsteroids($candidateLine, $candidateCol);
                echo $candidateLine, 'x', $candidateCol, ':', $asteroidsSeen, "\n";
                $maxSeen = max($maxSeen, $asteroidsSeen);
            }
        }
        echo $maxSeen;
/*  */
    }

    private function countVisibleAsteroids(int $candidateLine, int $candidateCol): int
    {
        $count = 0;
        foreach ($this->map as $line => $lineValue) {
            foreach ($lineValue as $col => $colValue) {
                if ($line === $candidateLine && $col === $candidateCol) {
                    echo '@';
                    continue;
                }
                if ($colValue !== '#') {
                    echo '.';
                    continue;
                }

                $deltaLine = abs($candidateLine - $line);
                $deltaCol  = abs($candidateCol - $col);

                $gcd = common\math::greatestCommonDivisor($deltaCol, $deltaLine);

                if (1 === $gcd) {  // no field inbetween -> visible.
                    echo 'S';
                    $count++;
                    continue;
                }

                if ($deltaCol === 0 || $deltaLine === 0 || $this->isDiagonal($deltaCol, $deltaLine)) {
                    $stepCol  = ($col  !== $candidateCol)  ? 1 : 0;
                    $stepLine = ($line !== $candidateLine) ? 1 : 0;
                } else {
                    $stepCol  = $deltaCol  / $gcd;
                    $stepLine = $deltaLine / $gcd;
                }

                $found = false;
                $lineSign = ($line > $candidateLine) ? 1 : -1;
                $colSign  = ($col  > $candidateCol)  ? 1 : -1;

                $i = 1;
                $checkLine = $candidateLine + ($i * $stepLine * $lineSign);
                $checkCol  = $candidateCol  + ($i * $stepCol  * $colSign);
                while (!($checkCol === $col && $checkLine === $line)) {
                    if ($this->map[$checkLine][$checkCol] === '#') {
                        echo 'h';
                        $found = true;
                        break;
                    }
                    $checkLine = $candidateLine + ($i * $stepLine * $lineSign);
                    $checkCol  = $candidateCol  + ($i * $stepCol  * $colSign);
                    $i++;
                }

                if (!$found) {
                    echo 'S';
                    $count++;
                }
            }
            echo "\n";
        }
        return $count;
    }

    private function isDiagonal (int $deltaCol, int $deltaLine): bool {
        $absDeltaCol  = abs($deltaCol);
        $absDeltaLine = abs($deltaLine);
        return $absDeltaCol === $absDeltaLine;
    }

    private function readMap(): void
    {
        $input = file(__DIR__ . '/in.txt', FILE_IGNORE_NEW_LINES);
        foreach ($input as $line) {
            $this->map[] = str_split($line);
        }
    }

    private function printMap(): void
    {
        foreach ($this->map as $line) {
            echo implode('', $line), "\n";
        }
    }
}

$solver = new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
