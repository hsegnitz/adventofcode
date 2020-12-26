<?php

//$timestamp = 939;
//$rawBuses = '7,13,x,x,59,x,31,19';

$timestamp = 1000340;
$rawBuses = '13,x,x,x,x,x,x,37,x,x,x,x,x,401,x,x,x,x,x,x,x,x,x,x,x,x,x,17,x,x,x,x,19,x,x,x,23,x,x,x,x,x,29,x,613,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,41';

$buses = explode(',', $rawBuses);

$buses = array_filter($buses, function ($value) { return $value !== 'x'; });

function nextArrival(int $timestamp, int $busId): int
{
    $mod = $timestamp % $busId;
    return $busId - $mod;
}

$nextArrivals = [];
foreach ($buses as $busId) {
    $nextArrivals[$busId] = nextArrival($timestamp, (int)$busId);
}

asort($nextArrivals);

print_r($nextArrivals);

foreach ($nextArrivals as $k => $v) {
    echo $k*$v, "\n";
    break;
}