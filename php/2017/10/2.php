<?php

use \Y2017\D10\KnotHash;

$startTime = microtime(true);

require_once 'KnotHash.php';

echo (new KnotHash())->hash(''), "\n";
echo (new KnotHash())->hash('AoC 2017'), "\n";
echo (new KnotHash())->hash('1,2,3'), "\n";
echo (new KnotHash())->hash('1,2,4'), "\n";
echo (new KnotHash())->hash("46,41,212,83,1,255,157,65,139,52,39,254,2,86,0,204"), "\n";


echo "total time: ", (microtime(true) - $startTime), "\n";

