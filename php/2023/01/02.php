<?php

$start = microtime(true);

#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;
foreach ($lines as $line) {
#    echo $line, " > ";
    $first = findDigitForward($line);
    $last = findDigitBackward($line);
    $num = $first . $last;
#    echo $num, "\n";
    $sum += (int)$num;
}

echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";




function findDigitForward(string $line): int
{
    for ($i = 0, $len = strlen($line); $i < $len; $i++) {
        $substr = substr($line, $i);
        if (str_starts_with($substr, 'one') || str_starts_with($substr, '1')) {
            return 1;
        }
        if (str_starts_with($substr, 'two') || str_starts_with($substr, '2')) {
            return 2;
        }
        if (str_starts_with($substr, 'three') || str_starts_with($substr, '3')) {
            return 3;
        }
        if (str_starts_with($substr, 'four') || str_starts_with($substr, '4')) {
            return 4;
        }
        if (str_starts_with($substr, 'five') || str_starts_with($substr, '5')) {
            return 5;
        }
        if (str_starts_with($substr, 'six') || str_starts_with($substr, '6')) {
            return 6;
        }
        if (str_starts_with($substr, 'seven') || str_starts_with($substr, '7')) {
            return 7;
        }
        if (str_starts_with($substr, 'eight') || str_starts_with($substr, '8')) {
            return 8;
        }
        if (str_starts_with($substr, 'nine') || str_starts_with($substr, '9')) {
            return 9;
        }
        if (str_starts_with($substr, '0')) {
            return 0;
        }
    }
    throw new \RuntimeException('no digit found');
}

function findDigitBackward(string $line): int
{
    for ($i = strlen($line); $i > 0; $i--) {
        $substr = substr($line, 0, $i);
        #echo "\n";
        if (str_ends_with($substr, 'one') || str_ends_with($substr, '1')) {
            return 1;
        }
        if (str_ends_with($substr, 'two') || str_ends_with($substr, '2')) {
            return 2;
        }
        if (str_ends_with($substr, 'three') || str_ends_with($substr, '3')) {
            return 3;
        }
        if (str_ends_with($substr, 'four') || str_ends_with($substr, '4')) {
            return 4;
        }
        if (str_ends_with($substr, 'five') || str_ends_with($substr, '5')) {
            return 5;
        }
        if (str_ends_with($substr, 'six') || str_ends_with($substr, '6')) {
            return 6;
        }
        if (str_ends_with($substr, 'seven') || str_ends_with($substr, '7')) {
            return 7;
        }
        if (str_ends_with($substr, 'eight') || str_ends_with($substr, '8')) {
            return 8;
        }
        if (str_ends_with($substr, 'nine') || str_ends_with($substr, '9')) {
            return 9;
        }
        if (str_starts_with($substr, '0')) {
            return 0;
        }
    }
    throw new \RuntimeException('no digit found');
}