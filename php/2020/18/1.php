<?php

$startTime = microtime(true);

$input = file(__DIR__ . '/in.txt');

function solve(string $string): int
{
    $string = trim($string);

    while (false !== strpos($string, '(')) {
        if (! preg_match('/\(([^()]+)\)/', $string, $out)) {
            throw new RuntimeException('regex don\'t match'); // [sic]  --  sing it to "papa don't preach"
        }

        $string = str_replace(
            '(' . $out[1] . ')',
            solve($out[1]),
            $string
        );
    }

    // from here on no parentheses left!

    $tokens = explode(' ', $string);
    while (count($tokens) > 1) {
        $subj1 = (int)array_shift($tokens);
        $op    = array_shift($tokens);
        $subj2 = (int)array_shift($tokens);
        if ($op === '+') {
            array_unshift($tokens, $subj1 + $subj2);
        } elseif ($op === '*') {
            array_unshift($tokens, $subj1 * $subj2);
        } else {
            throw new RuntimeException('WTF Dude!?');
        }
    }

    return array_shift($tokens);
}


$solutions = [];
foreach ($input as $row) {
    $solutions[] = solve($row);
}

print_r($solutions);

echo array_sum($solutions);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

