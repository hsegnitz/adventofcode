<?php

namespace Year2023\Day05;

$start = microtime(true);

#$input = file_get_contents('example.txt');
$input = file_get_contents('input.txt');

include '02-classes.php';

$blocks = explode("\n\n", $input);
$seeds = explode(" ", array_shift($blocks));
array_shift($seeds);

$seedRanges = [];
foreach (array_chunk($seeds, 2) as $chunk) {
    $seedRanges[] = new SeedRange($chunk[0], $chunk[0]+$chunk[1]-1);
}

$maps = [];
foreach ($blocks as $block) {
    $maps[] = new Map($block);
}

$outSeedRanges = $seedRanges;
usort($outSeedRanges, function (SeedRange $a, SeedRange $b) {
    return $a->lower <=> $b->lower;
});

foreach ($maps as $map) {
    $outSeedRanges = $map->convert($outSeedRanges);
    usort($outSeedRanges, function (SeedRange $a, SeedRange $b) {
        return $a->lower <=> $b->lower;
    });
}


echo $outSeedRanges[0]->lower;

echo "\n";

echo microtime(true) - $start;
echo "\n";
