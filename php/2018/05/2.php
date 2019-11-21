<?php

$input = file_get_contents('in.txt');

$lower = range('a', 'z');
$upper = range('A', 'Z');

$fullRegex = '/(';
foreach ($lower as $index => $l) {
    $fullRegex .= $l . $upper[$index] . '|';
}

foreach ($upper as $index => $l) {
    $fullRegex .= $l . $lower[$index] . '|';
}

$fullRegex .= ')/';


$removes = [];
foreach ($lower as $l) {
    $removes[$l] = [$l, strtoupper($l)];
}

$results = [];
foreach ($removes as $k => $r) {
    $results[$k] = reactFull(str_replace($r, '', $input));
}

print_r($results);





function reactFull($input)
{
    while (true) {
        $output = preg_replace($GLOBALS['fullRegex'], '', $input);
        if ($input !== $output) {
            $input = $output;
            continue;
        }
        return strlen($output);
    }
}


