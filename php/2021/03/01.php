<?php

$startTime = microtime(true);

#$input = file('./example.txt');
$input = file('./in.txt');

$map = [];
foreach($input as $line) {
    $map[] = str_split(trim($line));
}

$epsilon = $gamma = '';

for ($i = 0, $iMax = count($map[0]); $i < $iMax; $i++) {
    $cnt = array_count_values(array_column($map, $i));
    if ($cnt[0] > $cnt[1]) {
        $gamma .= '0';
        $epsilon .= '1';
    } elseif ($cnt[0] < $cnt[1]) {
        $gamma .= '1';
        $epsilon .= '0';
    } else {
        throw new Exception('gleichstand?!');
    }
}

$gamma = bindec($gamma);
$epsilon = bindec($epsilon);

echo ($gamma * $epsilon), "\ntotal time: ", (microtime(true) - $startTime), "\n";

