<?php

$startTime = microtime(true);

#$input = file('./example0.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example1.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example2.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

require './Cube.php';
require './Reactor.php';

$reactor = new Reactor();

foreach ($input as $line) {
    if (!preg_match('/(on|off) x=([\-0-9]+)\.\.([\-0-9]+),y=([\-0-9]+)\.\.([\-0-9]+),z=([\-0-9]+)\.\.([\-0-9]+)/', $line, $out)) {
        throw new RuntimeException('<NELSON>HAAHAA!</NELSON>');
    }
    [,$onOff, $xFrom, $xTo, $yFrom, $yTo, $zFrom, $zTo] = $out;

    $cube = new Cube($xFrom, $xTo+1, $yFrom, $yTo+1, $zFrom, $zTo+1);

    if ($onOff === 'on') {
        $reactor->add($cube);
    } else {
        $reactor->remove($cube);
    }
}

echo $reactor->numberOfOns(), "\n";


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
