<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

[$polymer, $rawInstructions] = explode("\n\n", $input);

$instructions = [];
foreach (explode("\n", $rawInstructions) as $rawInstruction) {
    [$key, $value] = explode(" -> ", $rawInstruction);
    $instructions[$key] = $value;
}

function step(array $counts, array $instructions): array
{
    $newCounts = [];
    foreach ($counts as $key => $count) {
        $left  = $key[0] . $instructions[$key];
        $right = $instructions[$key] . $key[1];
        if (!isset($newCounts[$left])) {
            $newCounts[$left] = 0;
        }
        if (!isset($newCounts[$right])) {
            $newCounts[$right] = 0;
        }

        $newCounts[$left] += $count;
        $newCounts[$right] += $count;
    }

    return $newCounts;
}

$counts = [];
$next = '';
for ($i = 0, $max = strlen($polymer)-1; $i < $max; $i++) {
    $current = $polymer[$i];
    $next = $polymer[$i+1];
    if (!isset($counts["{$current}{$next}"])) {
        $counts["{$current}{$next}"] = 0;
    }
    ++$counts["{$current}{$next}"];
}

for ($i = 0; $i < 40; $i++) {
    $counts = step($counts, $instructions);
    #echo "$i: ", array_sum($counts), "\n";
}

$elementCount = [];
foreach ($counts as $key => $count) {
    if (!isset($elementCount[$key[0]])) {
        $elementCount[$key[0]] = 0;
    }
    $elementCount[$key[0]] += $count;
}
$elementCount[substr($polymer, -1)]++;

echo max($elementCount) - min($elementCount);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

