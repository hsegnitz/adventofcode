<?php

$numbers_raw = file('./in.txt');

$numbers = [];
foreach ($numbers_raw as $num) {
    $numbers[] = (int)$num;
}

sort($numbers);

$target = 2020;

foreach ($numbers as $a) {
    foreach ($numbers as $b) {
        if ($b > ($target-$a)) {
            continue 2;
        }

        if ($target === $a+$b) {
            echo $a*$b;
            die("\n");
        }
    }
}

