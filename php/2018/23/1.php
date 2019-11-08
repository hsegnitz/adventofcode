<?php

function manhattanDistance($leftA, $topA, $elevationA, $leftB, $topB, $elevationB)
{
    return abs($leftA - $leftB) + abs($topA - $topB) + abs($elevationA - $elevationB);
}

class bot
{
    private $x;
    private $y;
    private $z;
    private $r;

    public function __construct($x, $y, $z, $r)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->r = $r;
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
     * @param  bot  $bot
     * @return bool
     */
    public function isWithinRange($bot)
    {
        return manhattanDistance($this->getX(), $this->getY(), $this->getZ(), $bot->getX(), $bot->getY(), $bot->getZ()) <= $this->getR();
    }
}

$pattern = '/pos=<(-?\d+),(-?\d+),(-?\d+)>, r=(\d+)/';

$bots = [];
foreach (file('in.txt') as $row) {
    $out = [];
    preg_match($pattern, $row, $out);
    $bots[] = new bot($out[1], $out[2], $out[3], $out[4]);
}

usort($bots, function (bot $a, bot $b) {return $b->getR() - $a->getR();});

#print_r($bots);

$strongestBot = $bots[0];

$count = 0;
foreach ($bots as $bot) {
    if ($strongestBot->isWithinRange($bot)) {
        ++$count;
    }
}

echo $count, "\n";
