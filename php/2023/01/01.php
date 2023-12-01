<?php

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;
foreach ($lines as $line) {
    $digits = preg_replace('/[^0-9]/', '', $line);
    $digitsArray = str_split($digits, 1);
    $first = $digitsArray[array_key_first($digitsArray)];
    $last = $digitsArray[array_key_last($digitsArray)];
    $num = $first . $last;
    $sum += (int)$num;
}

echo $sum, "\n";