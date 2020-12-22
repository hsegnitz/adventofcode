<?php

$startTime = microtime(true);

//$input = [0, 3, 6];
//$input = [1, 3, 2];
//$input = [2, 1, 3];
//$input = [1, 2, 3];
//$input = [2, 3, 1];
//$input = [3, 2, 1];
//$input = [3, 1, 2];
$input = [1, 0, 16, 5, 17, 4];

$last = array_pop($input);
$memory = array_combine($input, range(1, count($input)));
$turn = count($input)+1;
while ($turn++ < 30000000) {
    if (!isset($memory[$last])) {
        $memory[$last] = $turn-1;
        $last = 0;
    } else {
        $previousTurnForNumber = $memory[$last];
        $memory[$last] = $turn-1;
        $last = $turn - 1 - $previousTurnForNumber;
    }
}

echo $last;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

