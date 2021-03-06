<?php

function manhattanDistance($leftA, $topA, $elevationA, $leftB, $topB, $elevationB)
{
    return abs($leftA - $leftB) + abs($topA - $topB) + abs($elevationA - $elevationB);
}

class bot
{
    private static $instanceCount = 0;

    public static $minX   = PHP_INT_MAX;
    public static $minY   = PHP_INT_MAX;
    public static $minZ   = PHP_INT_MAX;
    public static $maxX   = 0;
    public static $maxY   = 0;
    public static $maxZ   = 0;
    public static $maxAbs = 0;

    private $id;
    private $x;
    private $y;
    private $z;
    private $r;

    public function __construct($x, $y, $z, $r)
    {
        $this->id = self::$instanceCount++;
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->r = $r;

        self::$minX = min(self::$minX, $x);
        self::$minY = min(self::$minY, $y);
        self::$minZ = min(self::$minZ, $z);
        self::$maxX = max(self::$maxX, $x);
        self::$maxY = max(self::$maxY, $y);
        self::$maxZ = max(self::$maxZ, $z);

        self::$maxAbs = max(
            self::$maxAbs,
            abs($x) + $r,
            abs($y) + $r,
            abs($z) + $r
        );
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return mixed
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * @return mixed
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  bot  $bot
     * @return bool
     */
    public function isWithinAddedRange($bot)
    {
        return manhattanDistance($this->getX(), $this->getY(), $this->getZ(), $bot->getX(), $bot->getY(), $bot->getZ()) <= ($this->getR() + $bot->getR());
    }
}

// let's see if we can explain this.
// we'll work our way from a super-huge box (kinda "the universe") down to smaller and smaller boxes and find each times the ones with the most bots in their range
// in case of ties we go with the larger box, in case of a tie there, we use the one closer to x=0, y=0, z=0




$pattern = '/pos=<(-?\d+),(-?\d+),(-?\d+)>, r=(\d+)/';

$bots = [];
foreach (file('in.txt') as $row) {
    $out = [];
    preg_match($pattern, $row, $out);
    $bots[] = new bot($out[1], $out[2], $out[3], $out[4]);
}

echo 'minX:   ', bot::$minX, '    ';
echo 'minY:   ', bot::$minY, '    ';
echo 'minZ:   ', bot::$minZ, '    ';
echo 'maxX:   ', bot::$maxX, '    ';
echo 'maxY:   ', bot::$maxY, '    ';
echo 'maxZ:   ', bot::$maxZ, '    ';
echo 'maxAbs: ', bot::$maxAbs, "\n";


$ranges = [];
/** @var bot $bot */
foreach ($bots as $bot) {
    $distanceFromCenter = manhattanDistance(0, 0, 0, $bot->getX(), $bot->getY(), $bot->getZ());
    $ranges[max(0, $distanceFromCenter - $bot->getR())] = 1;
    $ranges[$distanceFromCenter + $bot->getR()] = -1;
}

ksort($ranges);

//print_r($ranges);

$count = 0;
$result = 0;
$maxCount = 0;

foreach ($ranges as $key => $value) {
    $count += $value;
    if ($count > $maxCount) {
        $result = $key;
        $maxCount = $count;
    }
}

echo $result;






