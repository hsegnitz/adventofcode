<?php

$start = microtime(true);

#$lines = file_get_contents('example.txt');
$lines = file_get_contents('input.txt');

$rows = [];
foreach (explode("\n", $lines) as $line) {
    $rows[] = str_split($line);
}

$sum = 0;
while (count($rows[0]) > 0) {
    $nums = [];
    while (true) {
        $num = [];
        foreach ($rows as &$row) {
            $num[] .= array_pop($row);
        }
        if ($num[array_key_last($num)] === '+') {
            array_pop($num);
            $nums[] = (int)trim(implode('', $num));
            $sum += array_sum($nums);
            $nums = [];
            break;
        } elseif ($num[array_key_last($num)] === '*') {
            array_pop($num);
            $nums[] = (int)trim(implode('', $num));
            $sum += array_product($nums);
            $nums = [];
            break;
        } else {
            $tempNum = (int)trim(implode('', $num));
            if ($tempNum > 0) {
                $nums[] = $tempNum;
            }
        }
    }
}

# 1058
# 3253600
# 625
# 8544

# 3263827


echo "\n\n", $sum, "\n";
