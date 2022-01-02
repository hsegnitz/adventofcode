<?php

$startTime = microtime(true);

$circularBuffer = [0];

#$input = 3;
$input = 343;

$pos = 0;

for ($i = 1; $i <= 2017; $i++) {
    $pos = ($pos + $input) % count($circularBuffer);
    if ($pos === count($circularBuffer)-1) {
        $circularBuffer[] = $i;
    } else {
        $circularBuffer = array_merge(
            array_slice($circularBuffer, 0, $pos),
            [$i],
            array_slice($circularBuffer, $pos),
        );
    }
    $pos++;
}

print_r($circularBuffer);

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


