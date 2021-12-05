<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

$pipes = [];
foreach ($input as $rawPipe) {
    $split = explode(' -> ', $rawPipe);
    [$x1, $y1] = explode(',', $split[0]);
    [$x2, $y2] = explode(',', $split[1]);

    $pipes[] = [
        'x1' => (int)$x1,
        'y1' => (int)$y1,
        'x2' => (int)$x2,
        'y2' => (int)$y2,
    ];
}

$map = [];
foreach ($pipes as $pipe) {
    if ($pipe['x1'] !== $pipe['x2'] && $pipe['y1'] !== $pipe['y2']) {
        continue;
    }
    if ($pipe['x1'] === $pipe['x2']) {
        $x = $pipe['x1'];
        for ($y = min($pipe['y1'], $pipe['y2']); $y <= max($pipe['y1'], $pipe['y2']); $y++) {
            if (!isset($map["$x,$y"])) {
                $map["$x,$y"] = 0;
            }
            ++$map["$x,$y"];
        }
    }
    if ($pipe['y1'] === $pipe['y2']) {
        $y = $pipe['y1'];
        for ($x = min($pipe['x1'], $pipe['x2']); $x <= max($pipe['x1'], $pipe['x2']); $x++) {
            if (!isset($map["$x,$y"])) {
                $map["$x,$y"] = 0;
            }
            ++$map["$x,$y"];
        }
    }
}

$count = 0;
foreach ($map as $tile) {
    if ($tile > 1) {
        ++$count;
    }
}


echo $count, "\ntotal time: ", (microtime(true) - $startTime), "\n";


