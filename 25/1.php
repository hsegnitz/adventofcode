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

    public function __construct($x, $y, $z, $t)
    {
        $this->id = self::$instanceCount++;

        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->t = $t;
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

    public function
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





