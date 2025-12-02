<?php

$start = microtime(true);

#$input = file_get_contents('example1.txt');
$input = file_get_contents('input1.txt');

$input = str_replace(
    ['A', 'B', 'C'],
    ['0', '1', '3'],
    $input
);

echo array_sum(str_split($input, 1)), "\n";


echo microtime(true) - $start;
echo "\n";
