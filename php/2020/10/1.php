<?php

$startTime = microtime(true);

$input = file('in.txt');

$jolts = [];
foreach ($input as $num) {
    $jolts[] = (int)$num;
}

$jolts[] = 0; // the input
$jolts[] = (max($jolts) + 3); // the device

sort ($jolts);

$differences = [
    1 => 0,
    2 => 0,
    3 => 0,
];

$adaptorCount = count($jolts);

for ($i = 0; $i <= $adaptorCount -2; $i++) {
    $differences[$jolts[$i+1] - $jolts[$i]]++;
}

print_r($differences);

echo "Part 1: ", $differences[3] * $differences [1], "\n";


// ideas for speed: remove the middle (b) of   a -1- b -1- c  gaps  or 1,2  or 2,1   and  count them as another permutation
//

$permutations = array_fill(0, $adaptorCount, 0);
$permutations[0] = 1;
for ($i = 0; $i <= $adaptorCount -2; $i++) {
    for ($j = $i+1; $j <= $adaptorCount -1; $j++) {
        $diff = $jolts[$j] - $jolts[$i];
        if ($diff <= 3) {
            $permutations[$j] += $permutations[$i];
        } else {
           continue 2;
        }
    }
}


echo "Part 2: ", $permutations[$adaptorCount -1], "\n";




echo "total time: ", (microtime(true) - $startTime), "\n";
