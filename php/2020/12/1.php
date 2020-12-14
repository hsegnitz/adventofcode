<?php

$startTime = microtime(true);

$input = file(__DIR__ .'/in.txt');

$directions = ['N', 'E', 'S', 'W'];


$commands = [];
foreach ($input as $line) {
    $commands[] = [
        'action' => $line[0],
        'distance' => (int)substr($line, 1),
    ];
}

$facing = 1; // E
$posX = 0;
$posY = 0;

foreach ($commands as $command) {
    $action = $command['action'];
    if ('L' === $action || 'R' === $action) {
        $steps = $command['distance'] / 90;
        if ('L' === $action) {
            $steps *= -1;
        }
        $facing += $steps + 4;
        $facing %= 4;
        continue;
    }

    if ('F' === $action) {
        $action = $directions[$facing];
    }

    switch ($action) {
        case 'N':
            $posY -= $command['distance'];
            break;
        case 'S':
            $posY += $command['distance'];
            break;
        case 'E':
            $posX += $command['distance'];
            break;
        case 'W':
            $posX -= $command['distance'];
            break;
        default:
            throw new RuntimeException('WTF?!');
    }
}

echo manhattanDistance(0, 0, $posX, $posY);

echo "total time: ", (microtime(true) - $startTime), "\n";


function manhattanDistance($leftA, $topA, $leftB, $topB)
{
    return abs($leftA - $leftB) + abs($topA - $topB);
}

