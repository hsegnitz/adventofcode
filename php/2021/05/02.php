<?php

$startTime = microtime(true);

function incOrDec(int $one, int $two, int $current): int
{
    if ($one > $two) {
        return $current - 1;
    }
    if ($one < $two) {
        return $current + 1;
    }
    return $current;
}

function register ($x, $y, &$map): void {
    if (!isset($map["$x,$y"])) {
        $map["$x,$y"] = 0;
    }
    ++$map["$x,$y"];
}

#$input = file('./example.txt');
$input = file('./in.txt');

$map = [];
foreach ($input as $rawPipe) {
    $split = explode(' -> ', $rawPipe);
    [$x1, $y1] = explode(',', $split[0]);
    [$x2, $y2] = explode(',', $split[1]);

    $x1 = (int)$x1; $x2 = (int)$x2; $y1 = (int)$y1; $y2 = (int)$y2;

    $x = $x1;
    $y = $y1;
    register($x, $y, $map);
    while ([$x, $y] !== [$x2, $y2]) {
        $x = incOrDec($x1, $x2, $x);
        $y = incOrDec($y1, $y2, $y);
        register($x, $y, $map);
    }
}


$count = 0;
foreach ($map as $tile) {
    if ($tile > 1) {
        ++$count;
    }
}


echo $count, "\ntotal time: ", (microtime(true) - $startTime), "\n";


