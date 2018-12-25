<?php

$in = file('in.txt');

$count2 = 0;
$count3 = 0;

foreach ($in as $id) {
    $counts = count_chars($id);
    if (in_array(3, $counts)) {
        ++$count3;
    }
    if (in_array(2, $counts)) {
        ++$count2;
    }
}

echo $count2 * $count3;
