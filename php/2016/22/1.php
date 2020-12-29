<?php

$startTime = microtime(true);

$rawInput = file(__DIR__ . '/in.txt');
// ignore first two lines
array_shift($rawInput);
array_shift($rawInput);

$grid = [];
$flat = [];

# /dev/grid/node-x0-y0     89T   65T    24T   73%

foreach ($rawInput as $row) {
    if (!preg_match('#.*x(\d+)-y(\d+)\s+(\d+)T\s+(\d+)T\s+(\d+)T\s+(\d+)%#', $row, $out)) {
        throw new RuntimeException('Parser Error: ' . $row);
    }

    if (!isset($grid[$out[2]])) {
        $grid[$out[2]] = [];
    }
    $grid[$out[2]][$out[1]] = [
        'size' => $out[3],
        'used' => $out[4],
        'avail' => $out[5],
        'usePercent' => $out[6],
    ];

    $flat[$out[2].','.$out[1]] = $grid[$out[2]][$out[1]];
}

$count = 0;
foreach ($flat as $ka => $a) {
    foreach ($flat as $kb => $b) {
        if ($ka === $kb) {
            continue;
        }
        if ($a['used'] > 0 && $a['used'] <= $b['avail']) {
            ++$count;
        }
    }
}

echo $count;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
