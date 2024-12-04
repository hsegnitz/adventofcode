<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}

$variants = [
    [
        ['find' => 'M', 'col' => -1, 'row' => -1],
        ['find' => 'M', 'col' => -1, 'row' =>  1],
        ['find' => 'S', 'col' =>  1, 'row' => -1],
        ['find' => 'S', 'col' =>  1, 'row' =>  1],
    ],
    [
        ['find' => 'M', 'col' => -1, 'row' => -1],
        ['find' => 'S', 'col' => -1, 'row' =>  1],
        ['find' => 'M', 'col' =>  1, 'row' => -1],
        ['find' => 'S', 'col' =>  1, 'row' =>  1],
    ],
    [
        ['find' => 'S', 'col' => -1, 'row' => -1],
        ['find' => 'S', 'col' => -1, 'row' =>  1],
        ['find' => 'M', 'col' =>  1, 'row' => -1],
        ['find' => 'M', 'col' =>  1, 'row' =>  1],
    ],
    [
        ['find' => 'S', 'col' => -1, 'row' => -1],
        ['find' => 'M', 'col' => -1, 'row' =>  1],
        ['find' => 'S', 'col' =>  1, 'row' => -1],
        ['find' => 'M', 'col' =>  1, 'row' =>  1],
    ],
];


$count = 0;
foreach ($map as $rowNum => $row) {
    foreach ($row as $colNum => $char) {
        if ('A' !== $char) {
            continue;
        }
        foreach ($variants as $variant) {
            foreach ($variant as $target) {
                $searchCol = $colNum + $target['col'];
                $searchRow = $rowNum + $target['row'];
                if (!isset($map[$searchRow][$searchCol]) || $map[$searchRow][$searchCol] !== $target['find']) {
                    continue 2;
                }
            }
            ++$count;
            break;
        }
    }
}


echo $count, "\n";

echo microtime(true) - $start;
echo "\n";
