<?php

$startTime = microtime(true);

#$input = 'mjqjpqmgbljsphdztnvjfqwrcgsmlb';
#$input = 'bvwbjplbgvbhsrlpgdmjqwftvncz';
#$input = 'nppdvjthqldpwncqszvftbrmjlhg';
#$input = 'nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg';
#$input = 'zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw';
$input = file_get_contents('./in.txt');

$in = str_split($input);
for ($i = 13; $i < count($in); $i++) {
    $chunk = array_slice($in, $i-13, 14);
    if (array_unique($chunk) === $chunk) {
        break;
    }
}

echo "Part 2: ", $i+1;


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

