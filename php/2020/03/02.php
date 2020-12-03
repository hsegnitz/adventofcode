<?php

$map = file('./demo.txt');

function treeCollider(array $map, int $right, int $down): int
{
    $rowLength = strlen(trim($map[0]));

    $count = 0;
    for ($step = 1, $rowMax = count($map); ($step * $down) < $rowMax; $step++) {
        $row = $step * $down;
        $pos = ($right * $step) % $rowLength;
        if ($map[$row][$pos] === '#') {
            $count++;
        }
    }

    return $count;
}

$variants = [
    [1, 1],
    [3, 1],
    [5, 1],
    [7, 1],
    [1, 2],
];

$mul = 1;
foreach ($variants as $variant) {
    echo $count = treeCollider($map, $variant[0], $variant[1]);

    $mul *= $count;

    echo "\n";
}

echo $mul, "\n";
