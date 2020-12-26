<?php

require __DIR__ . '/GarbageGourmet.php';

$startTime = microtime(true);

$input = file(__DIR__ . '/in.txt');



echo "total time: ", (microtime(true) - $startTime), "\n";

