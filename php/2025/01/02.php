<?php

$start = microtime(true);

$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$dial = 50;
$zero = 0;

foreach ($lines as $line) {
    $distance = (int)substr($line, 1);
    $oldPos = $dial;
    if (str_starts_with($line, 'L')) {
        $dial -= $distance;
        if ($dial < 0) {
            $times = (int)ceil(abs($dial) / 100);
            $dial += 100 * $times;
            $zero += $times;
            if ($oldPos == 0) {
                --$zero;
            }
        }
    } else {
        $dial += $distance;
        if ($dial >= 100) {
            $times = (int)floor($dial / 100);
            $dial -= 100 * $times;
            $zero += $times;
            if ($dial == 0) {
                --$zero;
            }
        }
    }

    if ($dial == 0) {
        $zero++;
    }
}

echo "\n\n", $zero, "\n";
