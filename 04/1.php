<?php

$input = file('in.txt');
sort($input);

$guards = [];

$regexGuard = '/#(\d+) begins shift/';
$regexFallsAsleep = '/:(\d+)] falls asleep/';
$regexWakesUp     = '/:(\d+)] wakes up/';

$currentGuard = 0;
foreach ($input as $row) {
    $out = [];
    if (preg_match($regexGuard, $row, $out)) {
        $currentGuard = $out[1];
        if (!isset($guards[$currentGuard])) {
            $guards[$currentGuard] = [];
        }
        continue;
    }

    $guards[$currentGuard][] = $row;
}

$sleepSums = [];

foreach ($guards as $guardId => $sleepCycle) {
    $sleepSums[$guardId] = 0;
    while (count($sleepCycle) > 0) {
        $sleepRow = array_shift($sleepCycle);
        $wakeRow  = array_shift($sleepCycle);

        $out = [];
        preg_match($regexFallsAsleep, $sleepRow, $out);
        $sleepMinute = $out[1];

        $out = [];
        preg_match($regexWakesUp, $wakeRow, $out);
        $wakeMinute = $out[1];

        $sleepSums[$guardId] += ($wakeMinute - $sleepMinute);
    }
}

asort($sleepSums);
$keysLastSleepsLongest = array_keys($sleepSums);

$longestSleeper = array_pop($keysLastSleepsLongest);

$sleepmap = [];
$cycle = $guards[$longestSleeper];
while (count($cycle) > 0) {
    $sleepRow = array_shift($cycle);
    $wakeRow  = array_shift($cycle);

    $out = [];
    preg_match($regexFallsAsleep, $sleepRow, $out);
    $sleepMinute = $out[1];

    $out = [];
    preg_match($regexWakesUp, $wakeRow, $out);
    $wakeMinute = $out[1];

    for ($i = $sleepMinute; $i < $wakeMinute; $i++) {
        if (!isset($sleepmap[$i])) {
            $sleepmap[$i] = 0;
        }
        ++$sleepmap[$i];
    }
}

asort($sleepmap);

$minutes = array_keys($sleepmap);
$bestMinute = array_pop($minutes);

echo $longestSleeper, ' x ', $bestMinute, ' = ', ($longestSleeper * $bestMinute);

