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
            if ($grid[$enemy->getY()-1][$enemy->getX()] === '.') {
                $unoccupiedPointsAroundEnemies[] = ['x' => $enemy->getX(), 'y' => $enemy->getY()-1];
            }
            if ($grid[$enemy->getY()][$enemy->getX()-1] === '.') {
                $unoccupiedPointsAroundEnemies[] = ['x' => $enemy->getX()-1, 'y' => $enemy->getY()];
            }
            if ($grid[$enemy->getY()][$enemy->getX()+1] === '.') {
                $unoccupiedPointsAroundEnemies[] = ['x' => $enemy->getX()+1, 'y' => $enemy->getY()];
            }
            if ($grid[$enemy->getY()+1][$enemy->getX()] === '.') {
                $unoccupiedPointsAroundEnemies[] = ['x' => $enemy->getX(), 'y' => $enemy->getY()+1];
            }
        }

        print_r($unoccupiedPointsAroundEnemies);

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
foreach (file('move.txt') as $y => $row) {
    if ('' === ($row = trim($row))) {
        continue;
    }

    $grid[$y] = [];
    foreach (str_split($row) as $x => $char) {
        switch ($char) {
            case "E":
                $grid[$y][] = new elf($x, $y);
                break;
            case "G":
                $grid[$y][] = new goblin($x, $y);
                break;
            default:
                $grid[$y][] = $char;
        }
    }
}

printGrid($grid);

elf::$allUnits[0]->move($grid);



