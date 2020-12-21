<?php

$map = file('./in.txt');

$right = 3;
$rowLength = strlen(trim($map[0]));

$count = 0;
for ($row = 1, $rowMax = count($map); $row < $rowMax; $row++) {
    $pos = ($right * $row) % $rowLength;
    if ($map[$row][$pos] === '#') {
        $count++;
    }
}

echo $count, "\n";
