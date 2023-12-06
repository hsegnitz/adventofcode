<?php

namespace Year2023\Day06;

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$time   = preg_split("/:\s+/", $lines[0])[1];
$record = preg_split("/:\s+/", $lines[1])[1];

$time   = preg_replace("/\s+/", "", $time);
$record = preg_replace("/\s+/", "", $record);

echo $time, " ", $record, "\n";

$wins = 0;
for ($msHold = 1; $msHold < $time; $msHold++) {
    if ($msHold * ($time - $msHold) > $record) {
        ++$wins;
    }
}

echo $wins, "\n";

echo microtime(true) - $start;
echo "\n";

