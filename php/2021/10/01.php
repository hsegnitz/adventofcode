<?php

$startTime = microtime(true);

#$input = file('./example0.txt');
$input = file('./in.txt');

$pointMatrix = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$counts = [
    ')' => 0,
    ']' => 0,
    '}' => 0,
    '>' => 0,
];

$regexes = [
    ')' => '/[^()\]}>]\)/',
    ']' => '/[^\[)\]}>]]/',
    '}' => '/[^{)\]}>]}/',
    '>' => '/[^<)\]}>]>/',
];


foreach ($input as $originalLine) {
    echo $line = trim($originalLine);
    $oldLength = PHP_INT_MAX;
    while ($oldLength !== strlen($line)) {
        $oldLength = strlen($line);
        $line = preg_replace('/(\(\)|\[]|{}|<>)/', '', $line);
    }
    echo ': ', $line;

    // incomplete line has only opening brackets
    if (preg_match('/^[([{<]*$/', $line)) {
        echo " --- incomplete\n";
        continue;
    }

    foreach ($regexes as $char => $regex) {
        if (preg_match($regex, $line)) {
            echo " --- found {$char} \n";
            ++$counts[$char];
        }
    }
}

print_r($counts);

$score = 0;
foreach ($counts as $char => $count) {
    $score += $pointMatrix[$char] * $count;
}

echo $score;
echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


