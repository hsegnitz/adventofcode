<?php

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$dial = 50;
$zero = 0;

foreach ($lines as $line) {
    $distance = (int)substr($line, 1);
    if (str_starts_with($line, 'L')) {
        $dial -= $distance;
    } else {
        $dial += $distance;
    }

/*    while ($dial < 0) {
        $dial += 100;
    }
*/
    $dial %= 100;

    if ($dial === 0) {
        $zero++;
    }

    echo $dial, "\n";
}

echo "\n\n", $zero, "\n";
