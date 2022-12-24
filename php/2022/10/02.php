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
$lineLength = 40;
foreach ($commands as $command) {
    if ($command[0] === 'noop') {
        paint($frequency, $i);
        $i++;
        if ($i % $lineLength === 0) {
            echo "\n";
        }
        continue;
    }

    paint($frequency, $i);
    $i++;
    if ($i % $lineLength === 0) {
        echo "\n";
    }
    paint($frequency, $i);
    $i++;
    if ($i % $lineLength === 0) {
        echo "\n";
    }
    $frequency += $command[1];
}

function paint(int $frequency, int $cycle): void {
    if (in_array($cycle %40, [$frequency-1, $frequency, $frequency+1])) {
        echo "#";
        return;
    }
    echo ".";
}

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
