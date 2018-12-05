<?php

$input = file_get_contents('in.txt');

$lower = range('a', 'z');
$upper = range('A', 'Z');

$regex = '/(';
foreach ($lower as $index => $l) {
    $regex .= $l . $upper[$index] . '|';
}

foreach ($upper as $index => $l) {
    $regex .= $l . $lower[$index] . '|';
}

$regex .= ')/';

while (true) {
    $output = preg_replace($regex, '', $input);
    if ($input !== $output) {
        $input = $output;
        echo strlen($output), "\n";
        continue;
    }
    die (strlen($output));
}

