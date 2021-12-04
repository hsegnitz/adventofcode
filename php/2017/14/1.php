<?php

use Y2017\D10\KnotHash;

$startTime = microtime(true);

require_once '../10/KnotHash.php';

#$input = 'flqrgnkx';
$input = 'hxtvlmkl';

$field = '';
for ($i = 0; $i < 128; $i++) {
    $field .= (new KnotHash())->hashBinary($input . '-' . $i);
}

$counts = count_chars($field, 1);

echo $counts[49];

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


