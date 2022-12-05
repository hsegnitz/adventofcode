<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$stacks1 = [];
$instructions = [];

$split = explode("\n\n", $input);

$lines = explode("\n", $split[0]);
array_pop($lines);

foreach ($lines as $line) {
    for ($i = 1, $col = 1, $iMax = strlen($line); $i < $iMax; $i += 4, $col++) {
        if ($line[$i] !== ' ') {
            $stacks1[$col][] = $line[$i];
        }
    }
}

foreach ($stacks1 as &$stack) {
    $stack = array_reverse($stack);
}

unset($stack);

ksort($stacks1);
$stacks2 = $stacks1;

foreach (explode("\n", $split[1]) as $line) {
    [1 => $count, 3 => $from, 5 => $to] = explode(" ", $line);
    move900($stacks1, $count, $from, $to);
    move9001($stacks2, $count, $from, $to);
}


function move900 (array &$stacks, int $count, int $from, int $to): void
{
    for ($i = 0; $i < $count; $i++) {
        $stacks[$to][] = array_pop($stacks[$from]);
    }
}

function move9001 (array &$stacks, int $count, int $from, int $to): void
{
    foreach (array_slice($stacks[$from], -$count) as $crate) {
        $stacks[$to][] = $crate;
    }

    $stacks[$from] = array_slice($stacks[$from], 0, -$count);
}



echo "Part 1: ";

foreach ($stacks1 as $s) {
    echo $s[array_key_last($s)];
}

echo "\nPart 2: ";

#print_r($stacks2);

foreach ($stacks2 as $s2) {
    echo $s2[array_key_last($s2)];
}

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

