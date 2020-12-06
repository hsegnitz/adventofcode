<?php

$input = file_get_contents('./in.txt');
$groups = explode("\n\n", $input);

$sumCounts = 0;
foreach ($groups as $group) {
    $group = str_replace("\n", '', $group);
    $charCount = count_chars($group, 1);
    $sumCounts += count($charCount);
}

echo $sumCounts, "\n";
