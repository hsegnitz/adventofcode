<?php

$startTime = microtime(true);
/*

$input = 5; // 2
$input = 7; // 5
$input = 9; // 9
$input = 11; // 2
$input = 15; // 6
$input = 17; // 8
$input = 19; // 11
$input = 25; // 23
$input = 27; // 27
$input = 29; // 2
$input = 45; // 18
$input = 53; // 26
$input = 55; // 29
 *
 *
 *
/*    */

$elves = 15;
$sum = array_sum(range(1, ceil($elves/2)));
echo ($sum % $elves) + 1;


/*


#$list = range(1, 5);
$list = range(1, 3018458);


$current = 0;
while (count($list) > 1) {
    $count = count($list);
    $opposite = $current + floor($count / 2);
    $opposite %= $count;
    $current++;
    $current %= $count;
    $list = array_values($list);
    if ($count % 100 === 0) {
        echo $count, ": ", (microtime(true) - $startTime), "\n";
    }
    unset ($list[$opposite]);
}

print_r($list);
*/

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
