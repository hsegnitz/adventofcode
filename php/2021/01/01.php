<?php

#$input = file('./example.txt');
$input = file('./in.txt');

print_r($input);

$count = 0;

for($i = 1, $iMax = count($input); $i < $iMax; $i++) {
    if ((int)$input[$i-1] < (int)$input[$i]) {
        $count++;
    }
}

echo $count;
