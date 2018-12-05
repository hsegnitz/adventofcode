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

$sleepMap = [];

$max = 0;
$maxGuard = 0;
$maxMinute = 0;

foreach ($guards as $guardId => $sleepCycle) {
    $sleepMap[$guardId] = [];
    while (count($sleepCycle) > 0) {
        $sleepRow = array_shift($sleepCycle);
        $wakeRow  = array_shift($sleepCycle);

        $out = [];
        preg_match($regexFallsAsleep, $sleepRow, $out);
        $sleepMinute = $out[1];

        $out = [];
        preg_match($regexWakesUp, $wakeRow, $out);
        $wakeMinute = $out[1];

        for ($i = $sleepMinute; $i < $wakeMinute; $i++) {
            if (!isset($sleepMap[$guardId][$i])) {
                $sleepMap[$guardId][$i] = 0;
            }
            ++$sleepMap[$guardId][$i];
        }
    }

    if ($sleepMap[$guardId] === []) {
        continue;
    }

    $newMax = max($sleepMap[$guardId]);
    if ($newMax >  $max) {
        $maxGuard = $guardId;
        foreach ($sleepMap[$guardId] as $minute => $count) {
            if ($count == $newMax) {
                $maxMinute = $minute;
            }
        }
    }

}

echo $maxGuard, ' x ', $maxMinute, ' = ', ($maxMinute * $maxGuard);

