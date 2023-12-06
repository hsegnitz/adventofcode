<?php

namespace Year2023\Day06;

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$times   = preg_split("/\s+/", $lines[0]);
$records = preg_split("/\s+/", $lines[1]);

array_shift($times);
array_shift($records);
$waysToWin = [];

#print_r($records);

foreach ($times as $gameId => $time) {
    $wins = 0;
#    echo $record = $records[$gameId];
    $record = $records[$gameId];
    for ($msHold = 1; $msHold < $time; $msHold++) {
        if ($msHold * ($time - $msHold) > $record) {
            ++$wins;
        }
    }
    $waysToWin[$gameId] = $wins;
}

#print_r($waysToWin);

echo array_product($waysToWin);
echo "\n";

echo microtime(true) - $start;
echo "\n";

