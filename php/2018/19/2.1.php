<?php

/**
 * Okay then. it loops forever... BUT... after looking at what the steps output, where they loop and then crunching some numbers
 * the program adds up - in brute force - all the integer divisors (not just PRIME divisors as I intermediately thought and what
 * sent me down some rabbit hole!)
 *
 * We skip all the stuff and just pick the number from the output by hand.
 */


/**
 * @param  int   $start
 * @param  int   $in
 * @return int[]
 */
function divisors($start, $in)
{
    $return = [];
    for ($i = $start; $i <= $in; $i++) {
        if ($in % $i === 0) {
            $return[] = $i;
            $return = array_merge($return, divisors($i+1, $in/$i));
            $return[] = $in/$i;
        }
    }
    return array_unique($return);
}

$divisors = divisors(1, 10551425);
sort($divisors);
print_r($divisors);

echo "\n", array_sum($divisors), "\n";
