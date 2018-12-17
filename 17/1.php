<?php

class clayVein
{
    public static $minX = PHP_INT_MAX;
    public static $maxX = 0;
    public static $minY = PHP_INT_MAX;
    public static $maxY = 0;

    private $x;
    private $y;

    public function __construct($x, $y)
    {
        if (!is_array($x)) {
            $this->x = [$x, $x];
            $this->y = $y;
        } else {
            $this->x = $x;
            $this->y = [$y, $y];
        }

        self::$minX = min(self::$minX, $this->x[0], $this->x[1]);
        self::$maxX = max(self::$maxX, $this->x[0], $this->x[1]);
        self::$minY = min(self::$minY, $this->y[0], $this->y[1]);
        self::$maxY = max(self::$maxY, $this->y[0], $this->y[1]);
    }

    /**
     * @return array
     */
    public function getX(): array
    {
        return $this->x;
    }

    /**
     * @return array
     */
    public function getY(): array
    {
        return $this->y;
    }
}

function output($map)
{
    foreach ($map as $row) {
        foreach ($row as $col) {
            echo $col;
        }
        echo "\n";
    }
    echo "\n";
    usleep (500000);
}

function trickleDown(&$map, $x, $y)
{
    output($map);

    for ($newY = $y+1; $newY < count($map); $newY++) {
        if ('.' !== $map[$newY][$x]) {
            spread($map, $x, $newY-1);
            return;
        }
        $map[$newY][$x] = '|';
    }
}

// go left and right until we reach two borders or an edge.
// if two borders, fill up and go one step up along the original line (use $inX and )
function spread(&$map, $inX, $inY)
{
    output($map);

    $left = $right = false;

    $width = 0;
    $borders  = ['l' => 0, 'r' => 0];
    while ($left === false || $right === false) {
        $width++;

        if ($left === false) {
            if ('.' === $map[$inY][$inX-$width]) {
                if ('.' !== $map[$inY+1][$inX-$width]) {  // if left is sand and below it no sand, spread the pixel flowing
                    $map[$inY][$inX - $width] = '|';
                } else {   // if left is sand and below it is also sand, spread the pixel flowing and start a trickle down.
                    $map[$inY][$inX-$width] = '|';
                    $left = true;
                    trickleDown($map, $inX-$width, $inY);
                }
            } elseif ('#' === $map[$inY][$inX-$width]) {
                $left = true;
                $borders['l'] = $inX-$width;
            }
        }

        if ($right === false) {
            if ('.' === $map[$inY][$inX+$width]) {
                if ('.' !== $map[$inY+1][$inX+$width]) {  // if right is sand and below it no sand, spread the pixel flowing
                    $map[$inY][$inX + $width] = '|';
                } else {   // if right is sand and below it is also sand, spread the pixel flowing and start a trickle down.
                    $map[$inY][$inX+$width] = '|';
                    $right = true;
                    trickleDown($map, $inX+$width, $inY);
                }
            } elseif ('#' === $map[$inY][$inX+$width]) {
                $right = true;
                $borders['r'] = $inX+$width;
            }
        }
    }

    if (min($borders) !== 0) {
        for ($i = min($borders)+1; $i < max($borders); $i++) {
            $map[$inY][$i] = '~';
        }
        spread($map, $inX, $inY-1);
    }
}


$pattern = '/([xy])=(\d+), ([xy])=(\d+)..(\d+)/';
$list = [];
foreach (file('in-small.txt') as $line) {
    $out = [];
    preg_match($pattern, $line, $out);
    if ($out[1] === 'x') {
        $list[] = new clayVein($out[2], [$out[4], $out[5]]);
    } else {
        $list[] = new clayVein([$out[4], $out[5]], $out[2]);
    }
}

echo clayVein::$minX, '..', clayVein::$maxX, ' x ',  clayVein::$minY, '..',  clayVein::$maxY, "\n\n";

$map = [];

for ($y = 0; $y <= clayVein::$maxY+3; $y++) {
    $map[$y] = array_fill(clayVein::$minX - 5, clayVein::$maxX - clayVein::$minX + 10, '.');
}

$map[0][500] = '+';

/** @var clayVein $vein */
foreach ($list as $vein) {
    for ($y = $vein->getY()[0]; $y <= $vein->getY()[1]; $y++) {
        for ($x = $vein->getX()[0]; $x <= $vein->getX()[1]; $x++) {
            $map[$y][$x] = '#';
        }
    }
}


trickleDown($map, 500, 0);

output($map);






