<?php

class coordinate
{
    /** @var int */
    private static $instanceCount = 0;

    /** @var int */
    private $id;

    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var int */
    private $z;

    /** @var int */
    private $t;

    /**
     * coordinate constructor.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     * @param int $t
     */
    public function __construct($x, $y, $z, $t)
    {
        $this->id = self::$instanceCount++;

        $this->x = (int)$x;
        $this->y = (int)$y;
        $this->z = (int)$z;
        $this->t = (int)$t;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return int
     */
    public function getZ(): int
    {
        return $this->z;
    }

    /**
     * @return int
     */
    public function getT(): int
    {
        return $this->t;
    }

    /**
     * @param  coordinate $c
     * @return bool
     */
    public function isWithinRangeOf(coordinate $c)
    {
        return manhattanDistance4d($this, $c) <= 3;
    }
}

class constellation
{
    private static $instanceCount = 0;

    /** @var int */
    private $id;

    /** @var coordinate[] */
    private $stack = [];

    /**
     * constellation constructor.
     *
     * @param coordinate $c
     */
    public function __construct(coordinate $c)
    {
        $this->id = self::$instanceCount++;
        $this->stack[$c->getId()] = $c;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  coordinate $c
     * @return bool
     */
    public function incorporate(coordinate $c)
    {
        foreach ($this->stack as $id => $coordinate) {
            if ($coordinate->isWithinRangeOf($c)) {
                $this->stack[$c->getId()] = $c;
                return true;
            }
        }

        return false;
    }

    /**
     * @return coordinate[]
     */
    public function getCoordinates()
    {
        return $this->stack;
    }

    /**
     * @param  constellation $con
     * @return boolean true if successful, means the foreign constellation should be deleted outside.
     */
    public function combineConstellations(constellation $con)
    {
        if ($this === $con) {
            return false;
        }

        foreach ($con->getCoordinates() as $c) {
            if ($this->incorporate($c)) {
                // one match, quickly move all others over as they are now one bigger constellation
                foreach ($con->getCoordinates() as $d) {
                    $this->stack[$d->getId()] = $d;
                }
                return true;
            }
        }
        return false;
    }
}

/**
 * @param  coordinate $a
 * @param  coordinate $b
 * @return int
 */
function manhattanDistance4d(coordinate $a, coordinate $b)
{
    return
        abs($a->getX() - $b->getX()) +
        abs($a->getY() - $b->getY()) +
        abs($a->getZ() - $b->getZ()) +
        abs($a->getT() - $b->getT());
}


// being inside a constellation means: being within 3 fields of manhattan distance of one of the other coordinates which are already in the constellation.
// One point cannot be within two constellations so as soon as it is in one, it shall be removed from the list of available points.

$coordinates = [];
foreach (file('in.txt') as $row) {
    $split = explode(',', $row);
    if (count($split) === 4) {
        $coordinates[] = new coordinate((int)$split[0], (int)$split[1], (int)$split[2], (int)$split[3]);
    }
}

// phase 1 -- distribute all coordinates into constellations

$constellations = [];
while ($coordinates !== []) {
    $c = array_shift($coordinates);

    /** @var constellation $con */
    foreach ($constellations as $con) {
        if ($con->incorporate($c)) {
            continue 2; // continue outer loop as we found a home for this one.
        }
    }

    // no home found ( :( ) --> we'll start a new constellation for this one.
    $constellation = new constellation($c);
    $constellations[$constellation->getId()] = $constellation;
}

// phase 2 -- try to combine as much constellations as possible
// looping over and over again until nothing changes.

// merge OR append

$modified = true;
while ($modified) {
    $modified = false;
    $workingConstellations = [];
    /** @var constellation $c */
    foreach ($constellations as $c) {
        /** @var constellation $w */
        foreach ($workingConstellations as $w) {
            if ($w->combineConstellations($c)) {
                $modified = true;
                continue 2;
            }
        }
        $workingConstellations[$c->getId()] = $c;
    }
    $constellations = $workingConstellations;
}


#print_r($constellations);

echo count($constellations);
