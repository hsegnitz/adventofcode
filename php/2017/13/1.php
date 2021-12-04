<?php

namespace Y2017\D13\P1;

$startTime = microtime(true);

#$input = file('demo.txt');
$input = file('in.txt');


$scanners = [];

foreach($input as $row) {
    $split = explode(': ', $row);
    $scanners[] = new scanner((int)$split[0], (int)$split[1]);
}

$tripSeverity = 0;
foreach ($scanners as $scanner) {
    if ($scanner->isHitWhenStartedAt(0)) {
        echo "hit!";
        $tripSeverity += $scanner->getSeverity();
    }
}

echo $tripSeverity;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


class scanner
{
    private int $depth;
    private int $position;

    public function __construct(int $position, int $depth) {
        $this->position = $position;
        $this->depth = $depth;
    }

    public function isHitWhenStartedAt(int $picoSecond): bool {
        $scannerVPos = ($this->position + $picoSecond) % (($this->depth * 2) -2);
        return $scannerVPos === 0;
    }

    public function getSeverity(): int
    {
        return $this->depth * $this->position;
    }
}
