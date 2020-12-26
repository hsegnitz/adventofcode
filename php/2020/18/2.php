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

    // no parantheses left, all "equal"
    // add first

    while (false !== strpos($string, '+')) {
        if (! preg_match('/((\d+) \+ (\d+))/', $string, $out)) {
            throw new RuntimeException('regex don\'t match'); // [sic]  --  sing it to "papa don't preach"
        }

        $string = preg_replace(
            '/' . preg_quote($out[1], '/') . '/',
            $out[2] + $out[3],
            $string,
            1
        );
    }

    // from here on just multiply!

    while (false !== strpos($string, '*')) {
        if (! preg_match('/((\d+) \* (\d+))/', $string, $out)) {
            throw new RuntimeException('regex don\'t match'); // [sic]  --  sing it to "papa don't preach"
        }

        $string = preg_replace(
            '/' . preg_quote($out[1], '/') . '/',
            $out[2] * $out[3],
            $string,
            1
        );
    }

    if (!preg_match('/^\d+$/', $string)) {
        throw new RuntimeException('you are wrong! ' . $string);
    }

    return (int)$string;
}


$solutions = [];
foreach ($input as $row) {
    $solutions[] = solve($row);
}

print_r($solutions);

echo array_sum($solutions);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

