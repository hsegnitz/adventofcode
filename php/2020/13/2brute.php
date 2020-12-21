<?php
$startTime = microtime(true);
//$rawBuses = '17,x,13,19';
//$rawBuses = '67,7,59,61';
//$rawBuses = '67,x,7,59,61';
//$rawBuses = '67,7,x,59,61';
//$rawBuses = '1789,37,47,1889';
$rawBuses = '13,x,x,x,x,x,x,37,x,x,x,x,x,401,x,x,x,x,x,x,x,x,x,x,x,x,x,17,x,x,x,x,19,x,x,x,23,x,x,x,x,x,29,x,613,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,41';

$buses = explode(',', $rawBuses);

$buses = array_filter($buses, function ($value) { return $value !== 'x'; });

$second = 0;
$inc = $buses[0];
$i = 100000000000000 - (100000000000000 % $inc);
while (true) {
    //++$i;
    $i += $inc;

    foreach ($buses as $pos => $id) {
        if (0 !== ($pos+ $i) % $id) {
            continue 2;
        }
    }

    break;
}

echo "turns: ", $i , "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";