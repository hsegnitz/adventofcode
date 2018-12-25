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

$numOut = 0;

function output($map, $last = false, $debugX, $debugY)
{
    if ($GLOBALS['numOut']++ === 2001) {
        die();
    }

    if ($GLOBALS['numOut'] < 1900) {
        return;
    }

    echo $GLOBALS['numOut'], ": $debugX, $debugY\n";

    /*
    if ($GLOBALS['numOut'] % 1 != 0 && $last === false) {
        return;
    }
*/
    $image  = imagecreate(clayVein::$maxX+3, clayVein::$maxY);
    $colors = [
        '.' => imagecolorallocate($image, 255, 255,   0),
        '|' => imagecolorallocate($image,   0, 127, 255),
        '~' => imagecolorallocate($image,   0,   0, 255),
        '#' => imagecolorallocate($image, 160,  50,  20),
        '+' => imagecolorallocate($image, 255,   0,   0),
    ];

    foreach ($map as $numRow => $row) {
        foreach ($row as $numCol => $col) {
            imagesetpixel($image, $numCol, $numRow, $colors[$col]);
        }
    }

    $white = imagecolorallocate($image, 255, 255, 255);
    imagesetpixel($image, $debugX, $debugY, $white);

    imagepng($image, __DIR__ . '/out-' . $GLOBALS['numOut'] . '.png');
}

function trickleDown(&$map, $x, $y)
{
    output($map, false, $x, $y);

    for ($newY = $y+1; $newY < count($map); $newY++) {
        if ('|' === $map[$newY][$x]) {
            // I'm a second input - no need to flow further
            return;
        }
        if ('.' !== $map[$newY][$x]) {
            spread($map, $x, $newY-1);
            return;
        }
        $map[$newY][$x] = '|';
    }
}

// go left and right until we reach two borders or an edge.
// if two borders, fill up and go one step up along the original line (use $inX and $inY-1)
function spread(&$map, $inX, $inY)
{
    output($map, false, $inX, $inY);

    $left = $right = false;

    $width = 0;
    while ($left === false || $right === false) {
        $width++;

        if ($left === false) {
            if ('.' === $map[$inY][$inX-$width] || '|' === $map[$inY][$inX-$width]) {
                if ('.' === $map[$inY+1][$inX-$width] || '|' === $map[$inY+1][$inX-$width]) {
                    $left = true;
                    $leftOverflow = $inX-$width;
                }
            } elseif ('#' === $map[$inY][$inX-$width]) {
                $left = true;
                $leftBorder = $inX-$width;
            }
        }

        if ($right === false) {
            if ('.' === $map[$inY][$inX+$width] || '|' === $map[$inY][$inX+$width]) {
                if ('.' === $map[$inY+1][$inX+$width] || '|' === $map[$inY+1][$inX+$width]) {
                    $right = true;
                    $rightOverflow = $inX+$width;
                }
            } elseif ('#' === $map[$inY][$inX+$width]) {
                $right = true;
                $rightBorder = $inX+$width;
            }
        }
    }

    // paint

    $filler = '|';
    if (isset($leftBorder, $rightBorder)) {
        $filler = '~';
    }

    if (isset($leftBorder)) {
        $fillLeft = $leftBorder + 1;
    } else {
        $fillLeft = $leftOverflow;
    }

    if (isset($rightBorder)) {
        $fillRight = $rightBorder - 1;
    } else {
        $fillRight = $rightOverflow;
    }

    for ($i = $fillLeft; $i <= $fillRight; $i++) {
        $map[$inY][$i] = $filler;
    }

    // move on

    if (isset($leftBorder, $rightBorder)) {
        spread($map, $inX, $inY-1);
        return;
    }

    if (isset($leftOverflow)) {
        trickleDown($map, $leftOverflow, $inY);
    }

    if (isset($rightOverflow)) {
        trickleDown($map, $rightOverflow, $inY);
    }
}


$pattern = '/([xy])=(\d+), ([xy])=(\d+)..(\d+)/';
$list = [];
foreach (file('in.txt') as $line) {
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

output($map, true, 0, 0);

$countAll = 0;
$countStale = 0;
foreach ($map as $line => $row) {
    if ($line < clayVein::$minY) {
        continue;
    }
    foreach ($row as $col) {
        if ('|' === $col || '~' === $col) {
            ++$countAll;
            if ('~' === $col) {
                ++$countStale;
            }
        }
    }

    if ($line == clayVein::$maxY) {
        break;
    }
}

echo $countAll,   "\n\n";
echo $countStale, "\n\n";


