<?php

$startTime = microtime(true);

##$input = file('./example.txt');
$input = file('./in.txt');

$horz = $depth = $aim = 0;

foreach($input as $line) {
    [$direction, $distance] = explode(" ", $line);
    $distance = (int)$distance;
    switch ($direction) {
        case "forward":
            $horz += $distance;
            $depth += $aim * $distance;
            break;
        case "up":
            $aim -= $distance;
            break;
        case "down":
            $aim += $distance;
            break;
        default:
            throw new Exception('huh? ' . $line);
    }
}

echo ($horz * $depth), "\ntotal time: ", (microtime(true) - $startTime), "\n";

