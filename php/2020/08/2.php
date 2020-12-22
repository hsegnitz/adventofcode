<?php

$start = microtime(true);

//$input = file('demo2.txt');
$input = file('in.txt');

$instructions = [];
foreach ($input as $instruction) {
    $split = explode(" ", $instruction);
    $instructions[] = [
        'cmd' => $split[0],
        'val' => (int)$split[1],
    ];
}

function testProgram(array $instructions): ?int
{
    $accumulator = 0;
    $pointer = 0;
    $visited = [];
    while (!isset($visited[$pointer])) {
        $visited[$pointer] = true;
        if ($pointer === count($instructions)) { // position AFTER the last instruction!
            return $accumulator;
        }
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
    return null;
}

for ($i = 0, $iMax = count($instructions); $i < $iMax; $i++) {
    if ('acc' === $instructions[$i]['cmd']) {
        continue;
    }

    $instCopy = $instructions;
    switch ($instructions[$i]['cmd']) {
        case "nop":
            $instCopy[$i]['cmd'] = "jmp";
            break;
        case "jmp":
            $instCopy[$i]['cmd'] = "nop";
            break;
    }

    if (is_int($result = testProgram($instCopy))) {
        echo $result, "\n";
        break;
    }
}

echo microtime(true) - $start;
echo "\n";
