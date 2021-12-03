<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

$count = 0;

for($i = 3, $iMax = count($input); $i < $iMax; $i++) {
    if ((int)$input[$i-3] < (int)$input[$i]) {
        $count++;
    }
}

echo $count, "\ntotal time: ", (microtime(true) - $startTime), "\n";

