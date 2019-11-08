<?php

$in = file('01.txt');

$frequencies = [];
$current = 0;

while (true) {
    foreach ($in as $line) {
        $current += $line;
        if (isset($frequencies[$current])) {
            echo $current;
            die();
        }
        $frequencies[$current] = true;
    }
}
