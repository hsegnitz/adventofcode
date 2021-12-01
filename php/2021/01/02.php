<?php

#$input = file('./example.txt');
$input = file('./in.txt');

$count = 0;

for($i = 3, $iMax = count($input); $i < $iMax; $i++) {
    $sumA = array_sum(
        array_slice($input, $i-3, 3)
    );
    $sumB = array_sum(
        array_slice($input, $i-2, 3)
    );
    if ($sumA < $sumB) {
        $count++;
    }
}

echo $count;
