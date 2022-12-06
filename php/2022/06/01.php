<?php

$startTime = microtime(true);

#$input = 'mjqjpqmgbljsphdztnvjfqwrcgsmlb';
#$input = 'bvwbjplbgvbhsrlpgdmjqwftvncz';
#$input = 'nppdvjthqldpwncqszvftbrmjlhg';
#$input = 'nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg';
#$input = 'zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw';
$input = file_get_contents('./in.txt');

$in = str_split($input);
for ($i = 3; $i < count($in); $i++) {
    $chunk = array_slice($in, $i-3, 4);
    if (array_unique($chunk) === $chunk) {
        break;
    }
}

echo "Part 1: ", $i+1;


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

