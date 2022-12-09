<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$commands = [];
foreach ($input as $line) {
    $commands[] = explode(' ', $line);
}

$visited = [];
$xh = $yh = $xt = $yt = 0;
$visited["{$xt}x{$yt}"] = 1;

foreach ($commands as $command) {
    switch ($command[0]) {
        case "U":
            $deltaX = 0;
            $deltaY = -1;
            break;
        case "D":
            $deltaX = 0;
            $deltaY = 1;
            break;
        case "L":
            $deltaX = -1;
            $deltaY = 0;
            break;
        case "R":
            $deltaX = 1;
            $deltaY = 0;
            break;
        default:
            throw new \RuntimeException('weird direction received: ' . $command[0]);
    }

    for ($i = 0; $i < $command[1]; $i++) {
        $xh += $deltaX;
        $yh += $deltaY;
        if ($xh - $xt === 2) {
            ++$xt;
            $yt = $yh;
        } elseif ($xh - $xt === -2) {
            --$xt;
            $yt = $yh;
        } elseif ($yh - $yt === 2) {
            ++$yt;
            $xt = $xh;
        } elseif ($yh - $yt === -2) {
            --$yt;
            $xt = $xh;
        }

        $visited["{$xt}x{$yt}"] = 1;
    }
}



echo "part 1: ", count($visited);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

