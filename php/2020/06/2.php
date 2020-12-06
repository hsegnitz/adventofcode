<?php

$input = file_get_contents('./in.txt');
$groups = explode("\n\n", $input);

$sumCounts = 0;
foreach ($groups as $group) {
    $lines = explode("\n", $group);
    $answers = [];
    foreach ($lines as $line) {
        $answers[] = str_split($line);
    }
    $first = array_shift($answers);
    if (count($answers) > 0) {
        $result = array_intersect($first, ...$answers);
    } else {
        $result = $first;
    }
    $sumCounts += count($result);
}

echo $sumCounts, "\n";
