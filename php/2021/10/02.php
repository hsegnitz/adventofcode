<?php

$startTime = microtime(true);

#$input = file('./example0.txt');
$input = file('./in.txt');

function scoreLine(string $line): int
{
    $pointMatrix = [
        '(' => 1,
        '[' => 2,
        '{' => 3,
        '<' => 4,
    ];

    $line = strrev($line);

    $score = 0;
    for ($i = 0, $iMax = strlen($line); $i < $iMax; $i++) {
        $score *= 5;
        $score += $pointMatrix[$line[$i]];
    }

    return $score;
}


$regexes = [
    ')' => '/[^()\]}>]\)/',
    ']' => '/[^\[)\]}>]]/',
    '}' => '/[^{)\]}>]}/',
    '>' => '/[^<)\]}>]>/',
];

$scores = [];

foreach ($input as $originalLine) {
    echo $line = trim($originalLine);
    $oldLength = PHP_INT_MAX;
    while ($oldLength !== strlen($line)) {
        $oldLength = strlen($line);
        $line = preg_replace('/(\(\)|\[]|{}|<>)/', '', $line);
    }
    echo ': ', $line;

    // corrupt line has more than only opening characters, we want to skip them in part 2
    if (!preg_match('/^[([{<]*$/', $line)) {
        echo " --- incomplete\n";
        continue;
    }

    $scores[] = scoreLine($line);
}

sort($scores);

print_r($scores);

echo $scores[floor(count($scores)/2)];

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


