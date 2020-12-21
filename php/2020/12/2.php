<?php

$startTime = microtime(true);

$input = file(__DIR__ .'/in.txt');

$commands = [];
foreach ($input as $line) {
    $commands[] = [
        'action' => $line[0],
        'distance' => (int)substr($line, 1),
    ];
}

$posX = 0;
$posY = 0;

$wpX = 10;
$wpY = 1;

foreach ($commands as $command) {
    switch ($command['action']) {
        case 'F':
            $posX += $wpX * $command['distance'];
            $posY += $wpY * $command['distance'];
            break;
        case 'L':
        case 'R':
            $deg = $command['distance'];
            if ('L' === $command['action']) {
                $deg = 360 - $deg;
            }
            if (180 === $deg) {
                $wpX *= -1;
                $wpY *= -1;
            } elseif (90 === $deg) {
                $newWpY = $wpX * -1;
                $wpX = $wpY;
                $wpY = $newWpY;
            } elseif (270 === $deg) {
                $newWpX = $wpY * -1;
                $wpY = $wpX;
                $wpX = $newWpX;
            }
            break;
        case 'N':
            $wpY += $command['distance'];
            break;
        case 'S':
            $wpY -= $command['distance'];
            break;
        case 'E':
            $wpX += $command['distance'];
            break;
        case 'W':
            $wpX -= $command['distance'];
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

