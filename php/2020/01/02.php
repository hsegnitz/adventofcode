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
        if ($b > ($target - $a)) {
            continue 2;
        }

        foreach ($numbers as $c) {
            if ($c > ($target - $a - $b)) {
                continue 2;
            }

            if ($a + $b + $c === $target) {
                echo $a * $b * $c;
                die("\n");
            }
        }
    }
}

