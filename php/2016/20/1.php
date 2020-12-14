<?php

$startTime = microtime(true);

#$lines = file(__DIR__ . '/demo.txt');
#$lower = 0;
#$upper = 9;


$lines = file(__DIR__ . '/in.txt');
$lower = 0;
$upper = 4294967295;

// we could just create a 4GB large string of 1s and set the ranges to 0... I mean... what else to use the 64GB of RAM for Oo

// strategy:
// order by size of the range or rather by either upper or lower bound for speed?
// start with largest or lowest/highest

// walk the list and find ranges that overlap, reduce them into larger ones, reducing the number of total ranges.

// return the upper bound of the range that starts with 0 and add 1, if no range starts with zero it's too easy and we return 0.

$ranges = [];
foreach ($lines as $line) {
    $split = explode('-', $line);
    $ranges[] = [
        'lower' => (int)$split[0],
        'upper' => (int)$split[1],
    ];
}
unset ($lines, $line, $split);


usort($ranges, static function ($a, $b) {
   return $a['lower'] <=> $b['lower'];
});

$iterations = 0;
$foundSimplification = true;
while ($foundSimplification) {
    $newRanges = [];
    $foundSimplification = false;
    $current = array_shift($ranges);
    while(count($ranges)) {
        ++ $iterations;
        $next = array_shift($ranges);
        if ($current['upper'] >= $next['upper'] && $current['lower'] <= $next['lower']) {  // the next one lies within the previous!
            continue;
        }

        if ($current['upper'] >= $next['lower']-1) {
            // overlapping or adjacent --> combine and move on.
            $current['upper'] = $next['upper'];
            $foundSimplification = true;
            continue;
        }

        $newRanges[] = $current;
        $current = $next;
    }
    $newRanges[] = $current;
    $ranges = $newRanges;
}

echo $ranges[0]['upper'] + 1;
echo "\niterations: ", $iterations;
echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
