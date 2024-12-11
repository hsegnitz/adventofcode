<?php

$start = microtime(true);


#$input = file_get_contents('example.txt');
$input = file_get_contents('input.txt');

$rawStones = explode(' ', $input);
$stones = [];
foreach ($rawStones as $rawStone) {
    $stones[] = (int)$rawStone;
}

function blink(array $stones): array
{
    $newStones = [];
    foreach ($stones as $stone) {
        if ($stone === 0) {
            $newStones[] = 1;
            continue;
        }
        if (strlen((string)$stone) % 2 === 0) {
            [$left, $right] = str_split((string)$stone, strlen((string)$stone) / 2);
            $newStones[] = (int)$left;
            $newStones[] = (int)$right;
            continue;
        }
        $newStones[] = $stone * 2024;
    }
    return $newStones;
}

#echo implode (' ', $stones), "\n";
for ($i = 0; $i < 25; $i++) {
    $stones = blink($stones);
}
echo 'part 1: ', count($stones) . "\n";


echo microtime(true) - $start;
echo "\n";
