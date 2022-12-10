<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$strengths = $commands = [];
foreach ($input as $line) {
    $commands[] = explode(' ', $line);
}

$i = 0;
$frequency = 1;
$watches = [20, 60, 100, 140, 180, 220];
$commandBuffer = [];
while (count($commands)) {
    $i++;
    echo $i, ": ", $frequency, "\n";
    if (in_array($i, $watches)) {
        $strengths[] = $i * $frequency;
    }
    if ($commandBuffer === []) {
        $command = array_shift($commands);
        $commandBuffer = $command;
        if ($commandBuffer === ['noop']) {
            $commandBuffer = [];
        }
        continue;
    }

    if ($commandBuffer[0] === 'addx') {
        $frequency += $commandBuffer[1];
        $commandBuffer = [];
    }
}

print_r($strengths);

echo "part 1: ", array_sum($strengths);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

