<?php

$start = microtime(true);

#$lines = file('example2.txt', FILE_IGNORE_NEW_LINES);
#$lines = file('input.txt', FILE_IGNORE_NEW_LINES);
$lines = file_get_contents('input.txt');
$line = str_replace(["\r", "\n"], '', $lines);

// idea: just remove everything between don't() and do()
// which isn't an easy regex as this needs to be greedy for don't()s but ungreedy for do()s ;)
// everything AFTER a don't(), including consecutive don't()s needs to be gone, but that needs to stop after the first do()

// new strategy: split the lines by do() and remove everything after the first don't()
$sublines = explode("do()", $line);
$filteredLine = '';
foreach ($sublines as $subline) {
    $filteredLine .= ' ' . explode("don't()", $subline, 2)[0];
}

$sum = 0;
preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $filteredLine, $matches);
foreach ($matches[1] as $key => $value) {
    $sum += ($value * $matches[2][$key]);
}

echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";
