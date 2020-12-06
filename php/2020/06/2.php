<?php

$start = microtime(true);

$input = file_get_contents('./in.txt');
$groups = explode("\n\n", $input);

$sumCounts = 0;
foreach ($groups as $group) {
    $answers = explode("\n", $group);
    array_walk($answers, static function (&$value) { $value = str_split($value); });

    $result = array_shift($answers);
    if (count($answers) > 0) {
        $result = array_intersect($result, ...$answers);
    }
    $sumCounts += count($result);
}

echo $sumCounts, "\n";
echo microtime(true) - $start;
echo "\n";