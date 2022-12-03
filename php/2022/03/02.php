<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$priorities = array_merge(
    [0 => 'you will never find me!'],
    range('a', 'z'),
    range('A', 'Z')
);
$priorities = array_flip($priorities);

$scores = [];
foreach (array_chunk($input, 3) as $group) {
    $similar = array_values(
        array_intersect(
            splitAndUnique($group[0]),
            splitAndUnique($group[1]),
            splitAndUnique($group[2]),
        )
    );

    $scores[] = $priorities[$similar[0]];
}



function splitAndUnique(string $rawInput): array {
    return array_unique(
        str_split($rawInput)
    );
}

echo 'Part 2: ', array_sum($scores);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

