<?php

$startTime = microtime(true);

$input = file('./example0.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example1.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example2.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

require './Cube.php';

class Reactor
{
    /** @var Cube[] */
    private array $cubes = [];

    public function add(Cube $cube): void
    {
        $this->cubes[] = $cube;
    }

    public function remove(Cube $cube): void
    {
        //whatever
    }

    public function numberOfOns(): int
    {
        $sum = 0;
        foreach ($this->cubes as $cube) {
            $sum += $cube->volume();
        }
        return $sum;
    }
}


$reactor = new Reactor();

foreach ($input as $line) {
    if (!preg_match('/(on|off) x=([\-0-9]+)\.\.([\-0-9]+),y=([\-0-9]+)\.\.([\-0-9]+),z=([\-0-9]+)\.\.([\-0-9]+)/', $line, $out)) {
        throw new RuntimeException('<NELSON>HAAHAA!</NELSON>');
    }
    [,$onOff, $xFrom, $xTo, $yFrom, $yTo, $zFrom, $zTo] = $out;

    $xFrom = max($xFrom, -50);
    $xTo   = min($xTo,    50);
    $yFrom = max($yFrom, -50);
    $yTo   = min($yTo,    50);
    $zFrom = max($zFrom, -50);
    $zTo   = min($zTo,    50);

    $cube = new Cube($xFrom, $xTo, $yFrom, $yTo, $zFrom, $zTo);

    if ($onOff === 'on') {
        $reactor->add($cube);
    } else {
        $reactor->remove($cube);
    }

    echo $reactor->numberOfOns(), "\n";
}




echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

