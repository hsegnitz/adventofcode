<?php

use Y2017\D13\scanner;

$startTime = microtime(true);

require_once 'scanner.php';

#$input = file('demo.txt');
$input = file('in.txt');


$scanners = [];

foreach($input as $row) {
    $split = explode(': ', $row);
    $scanners[] = new scanner((int)$split[0], (int)$split[1]);
}

$tripSeverity = 0;
foreach ($scanners as $scanner) {
    if ($scanner->isHitWhenStartedAt(0)) {
        $tripSeverity += $scanner->getSeverity();
    }
}

echo $tripSeverity;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


