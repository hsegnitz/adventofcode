<?php

$startTime = microtime(true);


#$input = file('./demo.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$pieces = [];
foreach ($input as $line) {
    $pieces[] = explode('/', $line);
}

function build(array $current, array $left): array
{
    $match = $current[count($current)-1];
    $ret = [$current];
    foreach ($left as $num => $candidate) {
        if ($candidate[0] == $match) {
            $currentCopy = $current;
            $currentCopy[] = $candidate[0];
            $currentCopy[] = $candidate[1];
            $further = $left;
            unset($further[$num]);
            foreach (build($currentCopy, $further) as $next) {
                $ret[] = $next;
            }
        }
        if ($candidate[1] == $match) {
            $currentCopy = $current;
            $currentCopy[] = $candidate[1];
            $currentCopy[] = $candidate[0];
            $further = $left;
            unset($further[$num]);
            foreach (build($currentCopy, $further) as $next) {
                $ret[] = $next;
            }
        }
    }

    return $ret;
}

$sums = [];
$byLength = [];
foreach (build([0], $pieces) as $list) {
    $strength = array_sum($list);
    $sums[] = $strength;
    $byLength[count($list)][] = $strength;
}

echo "strongest: ", max($sums), "\n";
echo "strongest of the longest: ", max($byLength[max(array_keys($byLength))]), "\n";

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


