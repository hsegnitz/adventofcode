<?php

use common\ArrayKeyCache;

require_once '../../common/ArrayKeyCache.php';

$start = microtime(true);

#$lines = file('example5.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example6.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example4.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}

$startPoints = [];

foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $cell) {
        if ($cell == 0) {
            $startPoints[] = [$rowNum, $colNum];
        }
    }
}

class Wanderer {
    public function __construct(private readonly array $map) {

    }

    // find unique reachable 9s
    public function getRatingOf(int $startRow, int $startCol): int {
        return count($this->findListOfNines($startRow, $startCol, 1));
    }

    private function findListOfNines(int $startRow, int $startCol, int $next): array
    {
        if ($next === 10) {
            return [[$startRow, $startCol]];
        }

        $ret = [];
        if (isset($this->map[$startRow-1][$startCol]) && $this->map[$startRow-1][$startCol] == $next) {
            foreach ($this->findListOfNines($startRow - 1, $startCol, $next + 1) as $leaf) {
                $ret[] = $leaf;
            }
        }
        if (isset($this->map[$startRow+1][$startCol]) && $this->map[$startRow+1][$startCol] == $next) {
            foreach ($this->findListOfNines($startRow + 1, $startCol, $next + 1) as $leaf) {
                $ret[] = $leaf;
            }
        }
        if (isset($this->map[$startRow][$startCol-1]) && $this->map[$startRow][$startCol-1] == $next) {
            foreach ($this->findListOfNines($startRow, $startCol - 1, $next + 1) as $leaf) {
                $ret[] = $leaf;
            }
        }
        if (isset($this->map[$startRow][$startCol+1]) && $this->map[$startRow][$startCol+1] == $next) {
            foreach ($this->findListOfNines($startRow, $startCol + 1, $next + 1) as $leaf) {
                $ret[] = $leaf;
            }
        }
        return $ret;
    }
}


$wanderer = new Wanderer($map);
$score = 0;
foreach ($startPoints as $startPoint) {
    $score += $wanderer->getRatingOf($startPoint[0], $startPoint[1]);
}

echo $score, "\n";

echo microtime(true) - $start;
echo "\n";
