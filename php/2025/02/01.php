<?php

$start = microtime(true);

#$ranges = explode(",", file_get_contents('example.txt'));
$ranges = explode(",", file_get_contents('input.txt'));

$sum = 0;

foreach ($ranges as $range) {
    $analyser = new RangeAnalyser($range);
    foreach ($analyser->getInvalidIds() as $invalidId) {
        $sum += $invalidId;
    }
}

echo "\n\n", $sum, "\n";


class RangeAnalyser {
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

    public function isValidId(string $id): bool
    {
        if (strlen($id) % 2 !== 0) {
            return true;
        }

        $half = (int)floor(strlen($id) / 2);
        return substr($id, 0, $half) !== substr($id, $half);
    }
}

