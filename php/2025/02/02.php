<?php

require_once '../../common/math.php';

use common\math;

$start = microtime(true);

#$ranges = explode(",", file_get_contents('example.txt'));
$ranges = explode(",", file_get_contents('input.txt'));

$sum = 0;

foreach ($ranges as $range) {
    $analyser = new RangeAnalyser2($range);
    foreach ($analyser->getInvalidIds() as $invalidId) {
#        echo $invalidId, "\n";
        $sum += $invalidId;
    }
}

echo "\n\n", $sum, "\n";


class RangeAnalyser2 {
    private int $start;
    private int $end;
    public function __construct(string $rawRange)
    {
        [$start, $end] = explode('-', $rawRange);
        $this->start = (int)$start;
        $this->end = (int)$end;
    }

    public function getInvalidIds(): Generator
    {
        for ($i = $this->start; $i <= $this->end; $i++) {
            if (!$this->isValidId((string)$i)) {
                yield $i;
            }
        }
    }

    private function isValidId(string $id): bool
    {
        foreach (math::integerDivisors(strlen($id)) as $chunkSize) {
            if ($this->isRepeating($id, $chunkSize)) {
                return false;
            }
        }
        return true;
    }

    private function isRepeating(string $id, int $chunkSize): bool
    {
        if (strlen($id) === 1) {
            return false;
        }
        $chunks = str_split($id, $chunkSize);
        return count(array_unique($chunks)) === 1;
    }

}

