<?php

$start = microtime(true);

#$lines = file_get_contents('example.txt');
$lines = file_get_contents('input.txt');

$rows = [];
foreach (explode("\n", $lines) as $line) {
    $rows[] = explode(" ", preg_replace('/\s+/', ' ', trim($line)));
}

$sum = 0;
$operands = array_pop($rows);
foreach ($operands as $key => $operand) {
    $values = [];
    foreach ($rows as $row) {
        $values[] = $row[$key];
    }

    if ($operand === '+') {
        $sum += array_sum($values);
    } elseif ($operand === '*') {
        $sum += array_product($values);
    }
}


echo "\n\n", $sum, "\n";
