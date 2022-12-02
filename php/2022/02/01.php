<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$scores1 = [];
$scores2 = [];
foreach ($input as $line) {
    [$opponent, $me] = explode(' ', $line);
    $scores1[] = score($opponent, $me);
    $scores2[] = strategy($opponent, $me);
}

function strategy (string $opponent, string $strategy): int {
    return match ($opponent) {
        "A" => match ($strategy) {
            "X" => score($opponent, 'Z'),
            "Y" => score($opponent, 'X'),
            "Z" => score($opponent, 'Y'),
            default => throw new \RuntimeException('this should not happen: ' . $strategy),
        },
        "B" => match ($strategy) {
            "X" => score($opponent, 'X'),
            "Y" => score($opponent, 'Y'),
            "Z" => score($opponent, 'Z'),
            default => throw new \RuntimeException('this should not happen: ' . $strategy),
        },
        "C" => match ($strategy) {
            "X" => score($opponent, 'Y'),
            "Y" => score($opponent, 'Z'),
            "Z" => score($opponent, 'X'),
            default => throw new \RuntimeException('this should not happen: ' . $strategy),
        },
        default => throw new \RuntimeException('this should not happen: ' . $opponent),
    };
}

function score (string $opponent, string $me): int {
    return match ($opponent) {
        "A" => match ($me) {
            "X" => 1 + 3,   # rock
            "Y" => 2 + 6,   # paper
            "Z" => 3,       # scissor
            default => throw new \RuntimeException('this should not happen: ' . $me),
        },
        "B" => match ($me) {
            "X" => 1,
            "Y" => 2 + 3,
            "Z" => 3 + 6,
            default => throw new \RuntimeException('this should not happen: ' . $me),
        },
        "C" => match ($me) {
            "X" => 1 + 6,
            "Y" => 2,
            "Z" => 3 + 3,
            default => throw new \RuntimeException('this should not happen: ' . $me),
        },
        default => throw new \RuntimeException('this should not happen: ' . $opponent),
    };
}

echo "part 1: ", array_sum($scores1);
echo "\npart 2: ", array_sum($scores2);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

