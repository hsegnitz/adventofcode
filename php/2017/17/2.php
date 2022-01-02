<?php

$startTime = microtime(true);

#$input = 3;
$input = 343;

$pos = 0;

for ($i = 1; $i <= 50000001; $i++) {
    $pos = (($pos + $input) % $i) + 1;
    if ($pos === 1) {
        $valAfterZero = $i;
    }
}

echo $valAfterZero;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


