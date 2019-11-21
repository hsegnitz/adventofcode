<?php

$in = '#...#####.#..##...##...#.##.#.##.###..##.##.#.#..#...###..####.#.....#..##..#.##......#####..####...';
$generations = 500;  // here we'll have the pattern already...
$maxGen = 50000000000;

$rules = [
    '#.#.#' => '#',
    '..###' => '.',
    '#..#.' => '#',
    '.#...' => '#',
    '..##.' => '#',
    '##.#.' => '#',
    '##..#' => '#',
    '####.' => '#',
    '...#.' => '#',
    '..#.#' => '#',
    '.####' => '#',
    '#.###' => '.',
    '...##' => '.',
    '..#..' => '.',
    '#...#' => '.',
    '.###.' => '#',
    '.#.##' => '.',
    '.##..' => '#',
    '....#' => '.',
    '#..##' => '.',
    '##.##' => '#',
    '#.##.' => '.',
    '#....' => '.',
    '##...' => '#',
    '.#.#.' => '.',
    '###.#' => '#',
    '#####' => '#',
    '#.#..' => '.',
    '.....' => '.',
    '.##.#' => '.',
    '###..' => '.',
    '.#..#' => '.',
];

$all  = str_pad('', $generations, '.');
$all .= $in;
$all .= str_pad('', $generations, '.');


echo ' 0: ', $all, "\n";

$oldPlantsum = 0;
for($g = 1; $g <= $generations; $g++) {
    $upper = strlen($all)-2;
    $new = substr($all, 0, 2);
    for ($i = 2; $i < $upper; $i++) {
        $new .= $rules[substr($all, $i - 2, 5)];
    }
    $new .= '..';
    #echo str_pad($g, 2, ' ', STR_PAD_LEFT), ': ', $new, plantsum($new, $generations), "\n";
    $newPlantsum = plantsum($new, $generations);
    $delta = $newPlantsum - $oldPlantsum;
    echo str_pad($g, 5, ' ', STR_PAD_LEFT), ': ', $newPlantsum, ' -- ', $delta, "\n";
    $oldPlantsum = $newPlantsum;
    $all = $new;
}

$endSum = $newPlantsum + (($maxGen-$generations) * $delta);
echo $endSum;


function plantsum($new, $offset) {
    $sum = 0;
    $upper = strlen($new);
    for ($i = 0; $i < $upper; $i++) {
        if ($new[$i] === '#') {
            $sum += ($i - $offset);
        }
    }
    return $sum;
}
