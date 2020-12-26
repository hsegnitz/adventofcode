<?php

require __DIR__ . '/GarbageGourmet.php';

$startTime = microtime(true);

$input = trim(file_get_contents(__DIR__ . '/in.txt'));

$gg = new GarbageGourmet($input);

echo $gg->score(), "\n";



echo "total time: ", (microtime(true) - $startTime), "\n";

