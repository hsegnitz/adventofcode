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

function step(string $input, array $instructions): string
{
    $output = '';
    $next = '';
    for ($i = 0, $max = strlen($input)-1; $i < $max; $i++) {
        $current = $input[$i];
        $next = $input[$i+1];
        $output .= $current;
        if (isset($instructions["{$current}{$next}"])) {
            $output .= $instructions["{$current}{$next}"];
        }
    }
    return $output . $next;

}

for ($i = 0; $i < 10; $i++) {
    $polymer = step($polymer, $instructions);
}

$counts = count_chars($polymer, 1);
echo max($counts) - min($counts);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

