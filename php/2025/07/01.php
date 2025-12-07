<?php

$start = microtime(true);


#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$map = [];
foreach ($lines as $line) {
    $map[] = str_split($line);
}

$splits = 0;

foreach ($map as $posY => &$line) {
    if ($posY === 0) {
        continue;
    }
    foreach ($line as $posX => &$char) {
        if ($map[$posY-1][$posX] === 'S') {
            $char = '|';
        }
        if ($map[$posY-1][$posX] === '|') {
            if ($char === '^') {
                $splits++;
                $char = 'x';
                $map[$posY][$posX - 1] = $map[$posY][$posX + 1] = '|';
            } elseif ($char === '.') {
                $char = '|';
            }
        }
    }
}



echo "\n\n", $splits, "\n";
