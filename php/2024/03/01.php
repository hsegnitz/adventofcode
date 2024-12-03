<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;

foreach ($lines as $line) {
    preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $line, $matches);
    foreach ($matches[1] as $key => $value) {
        $sum += ($value * $matches[2][$key]);
    }
}


echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";
