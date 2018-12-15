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
            $unoccupiedPointsAroundEnemies = array_merge($unoccupiedPointsAroundEnemies, $this->freePointsAround($grid, $enemy->getX(), $enemy->getY()));
        }

        // might need to improve this
        // $unoccupiedPointsAroundEnemies = array_unique($unoccupiedPointsAroundEnemies);
         #print_r($unoccupiedPointsAroundEnemies);

        $reachable = [];
        $minDistance = PHP_INT_MAX;
        foreach ($unoccupiedPointsAroundEnemies as $upae) {
            $tempGrid = $grid;
            $tempGrid[$this->getY()][$this->getX()] = '.'; // we need to make ourself a possible waypoint ;)
            $waypoints = [$upae];
            $distance = 0;
            while ([] !== $waypoints) {
                $newWaypoints = [];
                foreach ($waypoints as $wp) {
                    if ($wp['x'] == $this->getX() && $wp['y'] == $this->getY()) {
                        $minDistance = min($minDistance, $distance);
                        $upae['d'] = $distance;
                        $reachable[] = $upae;
                        break 2;
                    }
                    $newWaypoints = array_merge($newWaypoints, $this->freePointsAround($tempGrid, $wp['x'], $wp['y'], $tempGrid));
                }
                $distance++;
                $waypoints = $newWaypoints;
                #printGrid($tempGrid);
            }
        }

        $nearest = [];
        $minY = PHP_INT_MAX;
        foreach ($reachable as $pos) {
            if ($pos['d'] === $minDistance) {
                $minY = min($minY, $pos['y']);
                $nearest[] = $pos;
            }
        }

        $topmost = [];
        $minX = PHP_INT_MAX;
        foreach ($nearest as $pos) {
            if ($pos['y'] != $minY) {
                continue;
            }

            $minX = min($minX, $pos['x']);
            $topmost[] = $pos;
        }

        foreach ($topmost as $pos) {
            if ($pos['x'] == $minX) {
                $chosen = $pos;
            }
        }

        print_r($pos);
    }

    private function freePointsAround($grid, $x, $y, &$tempGrid = null)
    {
        $freePoints = [];

        if ($grid[$y-1][$x] === '.') {
            $freePoints[] = ['x' => $x, 'y' => $y-1];
            if (null !== $tempGrid) {
                $tempGrid[$y-1][$x] = 'X';
            }
        }
        if ($grid[$y][$x-1] === '.') {
            $freePoints[] = ['x' => $x-1, 'y' => $y];
            if (null !== $tempGrid) {
                $tempGrid[$y][$x-1] = 'X';
            }
        }
        if ($grid[$y][$x+1] === '.') {
            $freePoints[] = ['x' => $x+1, 'y' => $y];
            if (null !== $tempGrid) {
                $tempGrid[$y][$x+1] = 'X';
            }
        }
        if ($grid[$y+1][$x] === '.') {
            $freePoints[] = ['x' => $x, 'y' => $y+1];
            if (null !== $tempGrid) {
                $tempGrid[$y+1][$x] = 'X';
            }
        }

        return $freePoints;
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



