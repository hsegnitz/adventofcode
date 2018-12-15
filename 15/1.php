<?php

class unit
{
    const ATTACK_POWER = 3;
    protected $hitPoints = 200;
    protected $id = 0;

    protected $posX = -1;
    protected $posY = -1;

    public function registerHit()
    {
        return $this->hitPoints -= self::ATTACK_POWER;
    }

    public function getId()
    {
        return $this->id;
    }

    public function move(&$grid)
    {
        $enemies = ($this instanceof elf) ? goblin::$allUnits : elf::$allUnits;

        $unoccupiedPointsAroundEnemies = [];
        foreach ($enemies as $enemy) {
            if ($grid[$enemy->getX()][$enemy->getY()-1])
        }

    }

    public function getX()
    {
        return $this->posX;
    }

    public function getY()
    {
        return $this->posY;
    }
}

class elf extends unit
{
    /** @var elf[] */
    public static $allUnits = [];
    private static $instanceCount = 0;

    public function __construct($posX, $posY)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->id = self::$instanceCount++;
        self::$allUnits[$this->id] = $this;
    }

    public function __toString()
    {
        return 'E';
    }
}

class goblin extends unit
{
    /** @var elf[] */
    public static $allUnits = [];
    private static $instanceCount = 0;

    public function __construct($posX, $posY)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->id = self::$instanceCount++;
        self::$allUnits[$this->id] = $this;
    }

    public function __toString()
    {
        return 'G';
    }
}

function printGrid($grid)
{
    foreach ($grid as $row) {
        foreach ($row as $char) {
            echo $char;
        }
        echo "\n";
    }
}




$grid = [];
foreach (file('in1.txt') as $num => $row) {
    if ('' === ($row = trim($row))) {
        continue;
    }

    $grid[$num] = [];
    foreach (str_split($row) as $y => $char) {
        switch ($char) {
            case "E":
                $grid[$num][] = new elf($num, $y);
                break;
            case "G":
                $grid[$num][] = new goblin($num, $y);
                break;
            default:
                $grid[$num][] = $char;
        }
    }
}


printGrid($grid);


