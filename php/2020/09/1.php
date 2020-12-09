<?php
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



for ($i = $groupLength; $i < count($numbers); $i++) {
    if (null === findSum(array_slice($numbers, ($i-$groupLength), $groupLength), $numbers[$i])) {
        echo $numbers[$i], "\n";
    }
}
