<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$fish = explode(',', $input);
array_walk($fish, static function (&$value) { $value = (int)$value; });

$counts = [];
foreach ($fish as $fishTimer) {
    if (!isset($counts[$fishTimer])) {
        $counts[$fishTimer] = 0;
    }
    ++$counts[$fishTimer];
}


for ($day = 0; $day < 256; $day++) {
    $newCounts = [];

    foreach ($counts as $fishTimer => $count) {
        if ($fishTimer > 0) {
            if (!isset($newCounts[$fishTimer-1])) {
                $newCounts[$fishTimer-1] = 0;
            }
            $newCounts[$fishTimer-1] += $count;
            continue;
        }

        if (!isset($newCounts[6])) {
            $newCounts[6] = 0;
        }
        $newCounts[6] += $count;
        $newCounts[8] = $count;
    }
    $counts = $newCounts;

    #echo $day, ':  ', implode(',', $counts), "\n";
    #echo $day, ':  ', array_sum($counts), "\n";
}

echo array_sum($counts);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


