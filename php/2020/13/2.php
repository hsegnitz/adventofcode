<?php

//$rawBuses = '17,x,13,19';
//$rawBuses = '67,7,59,61';
//$rawBuses = '67,x,7,59,61';
//$rawBuses = '67,7,x,59,61';
//$rawBuses = '1789,37,47,1889';
$rawBuses = '13,x,x,x,x,x,x,37,x,x,x,x,x,401,x,x,x,x,x,x,x,x,x,x,x,x,x,17,x,x,x,x,19,x,x,x,23,x,x,x,x,x,29,x,613,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,41';

$buses = explode(',', $rawBuses);

$buses = array_filter($buses, function ($value) { return $value !== 'x'; });

$mods = [];
foreach ($buses as $offset => $bus) {
    $mods[$bus] = (($bus**2) - $offset) % $bus;   // "bus^2" to prevent negative mods
}

$bus = array_key_first($mods);
$mod = $mods[$bus];
unset($mods[$bus]);

$multiplier = $bus;
$minutes = $mod;

$i = 0;
foreach ($mods as $nextBus => $nextMod) {
    while ($minutes % $nextBus !== $nextMod) {
        $minutes += $multiplier;
        ++$i;
    }
    $multiplier *= $nextBus;
}

echo $minutes, "\n";
echo $i, "\n";
