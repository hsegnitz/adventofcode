<?php

$elf1pos = 0;
$elf2pos = 1;

$scores = '37';

$num = 47801;

for ($i = 0; $i < $num + 6; $i++) {
    $score1 = (int)$scores[$elf1pos];
    $score2 = (int)$scores[$elf2pos];

    #echo str_pad($elf1pos, 6, ' ', STR_PAD_LEFT), ' : ', str_pad($elf2pos, 6, ' ', STR_PAD_LEFT), ' | ';
    $scores .= ($score1 + $score2);
    #echo "\n";

    $elf1pos = ($elf1pos + 1 + $score1) % strlen($scores);
    $elf2pos = ($elf2pos + 1 + $score2) % strlen($scores);
}

echo substr($scores, $num, 10), "\n";

