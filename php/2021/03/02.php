<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

$map = [];
foreach($input as $line) {
    $map[] = str_split(trim($line));
}


$oxy = implode('', reduceForMost($map, 1));
$scrubby = implode('', reduceForLeast($map, 0));


$oxy = bindec($oxy);
$scrubby = bindec($scrubby);



echo ($oxy * $scrubby), "\ntotal time: ", (microtime(true) - $startTime), "\n";


function reduceForMost(array $map, string $for): array {
    $col = 0;
    while (count($map) > 1) {
        $mostFrequent = mostFrequentForColumn($map, $col, $for);
        $newMap = [];
        foreach ($map as $row) {
            if ($row[$col] === $mostFrequent) {
                $newMap[] = $row;
            }
        }
        $col++;
        $map = $newMap;
    }
    return $map[0];
}

function reduceForLeast(array $map, string $for): array {
    $col = 0;
    while (count($map) > 1) {
        $mostFrequent = leastFrequentForColumn($map, $col, $for);
        $newMap = [];
        foreach ($map as $row) {
            if ($row[$col] === $mostFrequent) {
                $newMap[] = $row;
            }
        }
        $col++;
        $map = $newMap;
    }
    return $map[0];
}


function mostFrequentForColumn(array $map, int $column, string $default): string
{
    $cnt = array_count_values(array_column($map, $column));
    if ($cnt[0] > $cnt[1]) {
        return '0';
    }
    if ($cnt[0] < $cnt[1]) {
        return '1';
    }

    return $default;
}

function leastFrequentForColumn(array $map, int $column, string $default): string
{
    $cnt = array_count_values(array_column($map, $column));
    if ($cnt[0] < $cnt[1]) {
        return '0';
    }
    if ($cnt[0] > $cnt[1]) {
        return '1';
    }

    return $default;
}
