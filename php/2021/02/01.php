<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

$horz = $depth = 0;

foreach($input as $line) {
    [$direction, $distance] = explode(" ", $line);
    $distance = (int)$distance;
    switch ($direction) {
        case "forward":
            $horz += $distance;
            break;
        case "backward":
            $horz -= $distance;
            break;
        case "up":
            $depth -= $distance;
            break;
        case "down":
            $depth += $distance;
            break;
        default:
            throw new Exception('huh? ' . $line);
    }
}

echo ($horz * $depth), "\ntotal time: ", (microtime(true) - $startTime), "\n";

