<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$fish = explode(',', $input);
array_walk($fish, static function (&$value) { $value = (int)$value; });

for ($day = 0; $day < 80; $day++) {
    $spawn = 0;
    array_walk($fish, static function (&$value) use (&$spawn) {
        if ($value === 0) {
            $value = 6;
            ++$spawn;
        } else {
            --$value;
        }
    });
    for ($new = 0; $new < $spawn; $new++) {
        $fish[] = 8;
    }

    #echo $day, ':  ', implode(',', $fish), "\n";
}

$count = count($fish);

echo $count, "\ntotal time: ", (microtime(true) - $startTime), "\n";


