<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example2.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$commands = [];
foreach ($input as $line) {
    $commands[] = explode(' ', $line);
}

$visited = [];
$nodes = [];
for ($i = 0; $i <= 9; $i++) {
    $nodes[] = [0, 0];
}

$visited["0x0"] = 1;

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
        $nodes[0][0] += $deltaX;
        $nodes[0][1] += $deltaY;

        for ($j = 1; $j <= 9; $j++) {
            $dX = $nodes[$j-1][0] - $nodes[$j][0];
            $dY = $nodes[$j-1][1] - $nodes[$j][1];

            if (abs($dX) === 2) {
                $nodes[$j][0] += ($dX > 0 ? 1 : -1);
                if (abs($dY) === 1) {
                    $nodes[$j][1] += ($dY > 0 ? 1 : -1);
                }
            }

            if (abs($dY) === 2) {
                $nodes[$j][1] += ($dY > 0 ? 1 : -1);   // makes it + or - 1
                if (abs($dX) === 1) {
                    $nodes[$j][0] += ($dX > 0 ? 1 : -1);
                }
            }
        }
        $visited["{$nodes[9][0]}x{$nodes[9][1]}"] = 1;
#        viz($nodes);
    }
}

function viz($nodes): void
{
    $xs = $ys = $coords = [];
    foreach ($nodes as $num => $node) {
        $xs[] = $node[0];
        $ys[] = $node[1];
        $coords["{$node[0]}x{$node[1]}"] = $num;
    }

    $minX = min(-10, ...$xs);
    $maxX = max(10, ...$xs);
    $minY = min(-10, ...$ys);
    $maxY = max(10, ...$ys);

    for ($y = $minY; $y <= $maxY; $y++) {
        for ($x = $minX; $x <= $maxX; $x++) {
            echo $coords["{$x}x{$y}"] ?? '.';
        }
        echo "\n";
    }
    echo "\n";
}


echo "part 2: ", count($visited), "\n";


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

