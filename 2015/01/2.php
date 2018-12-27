<?php

$in = file_get_contents('in.txt');

$chars = str_split($in);

$sum = 0;
foreach ($chars as $count => $char) {
    if ($char === '(') {
        ++$sum;
    } elseif ($char === ')') {
        --$sum;
    }
    if ($sum === -1) {
        die ('result: ' . ($count + 1));
    }
}
