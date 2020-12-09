<?php
$startTime = microtime(true);

/*
$input = file('demo.txt');
$groupLength = 5;
*/

$input = file('in.txt');
$groupLength = 25;


$numbers = [];
foreach ($input as $num) {
    $numbers[] = (int)$num;
}

function findSum($numbers, $target): ?array {
    sort($numbers);

    foreach ($numbers as $ka => $a) {
        foreach ($numbers as $kb => $b) {
            if ($ka >= $kb) {
                continue;
            }

            if ($b > ($target-$a)) {
                continue 2;
            }

            if ($target === $a + $b) {
                return [$a, $b];
            }
        }
    }

    return null;
}

$invalid = -1;
for ($i = $groupLength; $i < count($numbers); $i++) {
    if (null === findSum(array_slice($numbers, ($i-$groupLength), $groupLength), $numbers[$i])) {
        $invalid = $numbers[$i];
    }
}

echo "Part 1: ", $invalid, " time: ", (microtime(true) - $startTime), "\nPart 2: ";

$total = count($numbers);
foreach ($numbers as $key => $num) {
    for ($length = 2; $length < ($total - $key); $length++) {
        $slice = array_slice($numbers, $key, $length);
        if (array_sum($slice) === $invalid) {
            echo $min = min($slice), " ", $max = max($slice), ": ", $min + $max, "\n";
        }
    }
}

echo "total time: ", (microtime(true) - $startTime), "\n";