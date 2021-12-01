<?php

#$input = file('./example.txt');
$input = file('./in.txt');

$count = 0;

for($i = 3, $iMax = count($input); $i < $iMax; $i++) {
    $sumA = (int)$input[$i-3] + (int)$input[$i-2] + (int)$input[$i-1];
    $sumB = (int)$input[$i-2] + (int)$input[$i-1] + (int)$input[$i];
    if ($sumA < $sumB) {
        $count++;
    }
}

echo $count;
