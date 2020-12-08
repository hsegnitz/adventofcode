<?php

$start = microtime(true);

//$input = file('demo.txt');
$input = file('in.txt');

$instructions = [];
foreach ($input as $instruction) {
    $split = explode(" ", $instruction);
    $instructions[] = [
        'cmd' => $split[0],
        'val' => (int)$split[1],
    ];
}

$accumulator = 0;
$pointer = 0;
$visited = [];
while (!isset($visited[$pointer])) {
    $visited[$pointer] = true;
    switch ($instructions[$pointer]['cmd']) {
        case "acc":
            $accumulator += $instructions[$pointer]['val'];
        case "nop":
            $pointer++;
            break;
        case "jmp":
            $pointer += $instructions[$pointer]['val'];
            break;
    }
}

echo $accumulator, "\n";

echo microtime(true) - $start;
echo "\n";