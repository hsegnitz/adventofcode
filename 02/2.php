<?php

$in = file('in.txt');

foreach ($in as $a) {
    foreach ($in as $b) {
        if ($a === $b) {
            continue;
        }

        if (levenshtein($a, $b) === 1) {
            echo $a, $b;
            die();
        }
    }
}
