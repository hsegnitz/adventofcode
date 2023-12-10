<?php

namespace Year2023\Day08;

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example3.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example4.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('example5.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = [];
$floodMap = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
    $floodMap[] = array_fill(0, strlen($line), '.');
}
#print_r($map);

$directionChanging = [
    '|' => ['N' => 'N', 'S' => 'S'],
    '-' => ['E' => 'E', 'W' => 'W'],
    'L' => ['S' => 'E', 'W' => 'N'],
    'J' => ['S' => 'W', 'E' => 'N'],
    '7' => ['E' => 'S', 'N' => 'W'],
    'F' => ['N' => 'E', 'W' => 'S'],
    'S' => ['+' => 'E'],   // all my inputs have a connection to the east.
];

$startX = $startY = 0;
foreach ($map as $y => $row) {
    foreach ($row as $x => $tile) {
        if ('S' === $tile) {
            $startX = $x;
            $startY = $y;
            break 2;
        }
    }
}

$steps = 0;
$facing = '+';
$tile = '';

while ($tile !== 'S' || $steps < 2) {
    $tile = $map[$y][$x];
    if ($tile === 'S' && isset($map[$y-1]) && in_array($map[$y - 1][$x], ['|', 'F', '7'], true)) {
        $floodMap[$y][$x] = 'L';
    } elseif ($tile === 'S' && isset($map[$y+1]) && in_array($map[$y + 1][$x], ['|', 'J', 'L'], true)) {
        $floodMap[$y][$x] = 'F';
    } else {
        $floodMap[$y][$x] = $tile;
    }
    $facing = $directionChanging[$tile][$facing];

    switch ($facing) {
        case 'E': ++$x; break;
        case 'S': ++$y; break;
        case 'W': --$x; break;
        case 'N': --$y; break;
    }

    ++$steps;
}

echo "\nFarthest: ", floor($steps/2), "\n";

// enlarge map so we ALWAYS have gaps!

$newFloodMap = $floodMap;

/*   nope, it's actually not needed.
foreach ($floodMap as $y => $row) {
    foreach ($row as $x => $tile) {
        if ($tile === 'F') {
            $newFloodMap[$y*2][$x*2] = 'F';
            $newFloodMap[$y*2][($x*2)+1] = '-';
            $newFloodMap[($y*2)+1][($x*2)] = '|';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
        if ($tile === '-') {
            $newFloodMap[$y*2][$x*2] = '-';
            $newFloodMap[$y*2][($x*2)+1] = '-';
            $newFloodMap[($y*2)+1][($x*2)] = '.';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
        if ($tile === '|') {
            $newFloodMap[$y*2][$x*2] = '|';
            $newFloodMap[$y*2][($x*2)+1] = '.';
            $newFloodMap[($y*2)+1][($x*2)] = '|';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
        if ($tile === 'J') {
            $newFloodMap[$y*2][$x*2] = 'J';
            $newFloodMap[$y*2][($x*2)+1] = '.';
            $newFloodMap[($y*2)+1][($x*2)] = '.';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
        if ($tile === '7') {
            $newFloodMap[$y*2][$x*2] = '7';
            $newFloodMap[$y*2][($x*2)+1] = '.';
            $newFloodMap[($y*2)+1][($x*2)] = '|';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
        if ($tile === 'L') {
            $newFloodMap[$y*2][$x*2] = 'L';
            $newFloodMap[$y*2][($x*2)+1] = '-';
            $newFloodMap[($y*2)+1][($x*2)] = '.';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
        if ($tile === '.') {
            $newFloodMap[$y*2][$x*2] = '.';
            $newFloodMap[$y*2][($x*2)+1] = '.';
            $newFloodMap[($y*2)+1][($x*2)] = '.';
            $newFloodMap[($y*2)+1][($x*2)+1] = '.';
        }
    }
}
*/

foreach ($newFloodMap as $y => $row) {
    $pipeCount = 0;
    $cornerCount = 0;
    $cornerStack = [];
    foreach ($row as $x => $tile) {
        if ($tile !== '.') {
            if ($tile === 'F' || $tile === 'L') {
                $cornerStack[] = $tile;
                ++$cornerCount;
            }
            if ($tile === '7') {
                if ($cornerStack[array_key_last($cornerStack)] === 'L') {
                    ++$pipeCount;
                }
                --$cornerCount;
            }
            if ($tile === 'J') {
                if ($cornerStack[array_key_last($cornerStack)] === 'F') {
                    ++$pipeCount;
                }
                --$cornerCount;
            }
            if ($tile === '|') {
                ++$pipeCount;
            }
            continue;
        }

        if (($pipeCount+$cornerCount) % 2 === 0) {
            $newFloodMap[$y][$x] = 'O';
        } else {
            $newFloodMap[$y][$x] = 'I';
        }

    }
}

echo "\n";
$out = '';
foreach ($newFloodMap as $row) {
    $out .= implode("", $row) . "\n";
}
echo $out, "\n";

echo count_chars($out)[ord('I')];

echo "\n";


echo microtime(true) - $start;
echo "\n";

