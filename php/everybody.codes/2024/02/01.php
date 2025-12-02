<?php

$start = microtime(true);

#$input = file_get_contents('example1.txt');
$input = file_get_contents('input1.txt');

[$words, $text] = explode("\n\n", $input);
$words = str_replace("WORDS:", "", $words);
$words = explode(",", $words);

$sum = 0;

foreach ($words as $word) {
    $sum += substr_count($text, $word);
}


echo $sum;

echo "\n";

echo microtime(true) - $start;
echo "\n";
