<?php

class unit
{
    const ATTACK_POWER = 3;
    protected $hitPoints = 200;
    protected $id = 0;

    protected $posX = -1;
    protected $posY = -1;

    public function registerHit($power)
    {
        return $this->hitPoints -= $power;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHitpoints()
    {
        return $this->hitPoints;
    }

    public function move(&$grid)
    {
        $enemies = ($this instanceof elf) ? goblin::$allUnits : elf::$allUnits;

        $unoccupiedPointsAroundEnemies = [];
        foreach ($enemies as $enemy) {
            if (1 === abs($this->posX - $enemy->getX()) + abs($this->posY - $enemy->getY())) {
                return; // we do not move, as we are standing next to an enemy
            }
            $unoccupiedPointsAroundEnemies = array_merge($unoccupiedPointsAroundEnemies, $this->freePointsAround($grid, $enemy->getX(), $enemy->getY()));
        }

        if (count($unoccupiedPointsAroundEnemies) === 0) {
            return;
        }

        // might need to improve this
        // $unoccupiedPointsAroundEnemies = array_unique($unoccupiedPointsAroundEnemies);
         #print_r($unoccupiedPointsAroundEnemies);

        $minDistance = PHP_INT_MAX;
        $reachable = $this->determineReachablePoints($grid, $unoccupiedPointsAroundEnemies, $minDistance, $this);

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

        #print_r($chosen);

        if (!isset($chosen)) {
            return;
        }

        $possibleMoves = [];
        $minDistance = PHP_INT_MAX;
        foreach ($this->freePointsAround($grid, $this->getX(), $this->getY()) as $possibleMove) {
            $minDistanceMove = PHP_INT_MAX;
            if ([] !== ($moveAndDistance = $this->determineReachablePoints($grid, [$possibleMove], $minDistanceMove, $chosen))) {
                $minDistance = min($minDistanceMove, $minDistance);
                $possibleMoves[] = $moveAndDistance[0];
            }
        }

        $moves = [];
        foreach ($possibleMoves as $move) {
            if ($move['d'] == $minDistance) {
                $moves[] = $move;
            }
        }

        if (count($moves) === 1) {
            $wayToGo = $moves[0];
        } elseif ($moves[0]['y'] < $moves[1]['y']) {
            $wayToGo = $moves[0];
        } elseif ($moves[0]['y'] > $moves[1]['y']) {
            $wayToGo = $moves[1];
        } elseif ($moves[0]['x'] < $moves[1]['x']) {
            $wayToGo = $moves[0];
        } else {
            $wayToGo = $moves[1];
        }

        #print_r($wayToGo);

        $grid[$wayToGo['y']][$wayToGo['x']] = $this;
        $grid[$this->getY()][$this->getX()] = '.';
        $this->posX = $wayToGo['x'];
        $this->posY = $wayToGo['y'];
    }

    public function attack(&$grid)
    {
        $adjacentTiles = [
            $grid[$this->getY()]  [$this->getX()-1],
            $grid[$this->getY()]  [$this->getX()+1],
            $grid[$this->getY()-1][$this->getX()],
            $grid[$this->getY()+1][$this->getX()],
        ];

        $enemies = [];
        $lowestHp = PHP_INT_MAX;
        foreach ($adjacentTiles as $tile) {
            if ($tile instanceof unit && ! $tile instanceof static) {
                $lowestHp = min($lowestHp, $tile->getHitpoints());
                $enemies[] = $tile;
            }
        }

        if (count($enemies) === 0) {
            return;
        }

        usort($enemies, function (unit $a, unit $b) {
            if ($a->getHitpoints() < $b->getHitpoints()) {
                return -1;
            }
            if ($a->getHitpoints() > $b->getHitpoints()) {
                return 1;
            }
            if ($a->getY() < $b->getY()) {
                return -1;
            }
            if ($a->getY() > $b->getY()) {
                return 1;
            }
            if ($a->getX() < $b->getX()) {
                return -1;
            }
            if ($a->getX() > $b->getX()) {
                return 1;
            }
            return 0;
        });

        /** @var unit $victim */
        $victim = $enemies[0];
        $resultingHP = $victim->registerHit(self::ATTACK_POWER);

        if ($resultingHP < 1) {
            $grid[$victim->getY()][$victim->getX()] = '.';
            if ($victim instanceof goblin) {
                unset(goblin::$allUnits[$victim->getId()]);
            } elseif ($victim instanceof elf) {
                unset(elf::$allUnits[$victim->getId()]);
            }
        }
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

    /**
     * @param       $grid
     * @param array $unoccupiedPointsAroundEnemies
     * @param       $minDistance
     * @return array
     */
    private function determineReachablePoints(&$grid, array $unoccupiedPointsAroundEnemies, &$minDistance, $target)
    {
        if ($target instanceof unit) {
            $targetX = $target->getX();
            $targetY = $target->getY();
        } else {
            $targetX = $target['x'];
            $targetY = $target['y'];
        }


        $reachable = [];
        foreach ($unoccupiedPointsAroundEnemies as $upae) {
            $tempGrid = $grid;
            $tempGrid[$targetY][$targetX] = '.'; // we need to make ourself a possible waypoint ;)
            $waypoints = [$upae];
            $distance = 0;
            while ([] !== $waypoints) {
                $newWaypoints = [];
                foreach ($waypoints as $wp) {
                    if ($wp['x'] == $targetX && $wp['y'] == $targetY) {
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

        return $reachable;
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

/**
 * @param  $grid
 * @return boolean
 */
function tick(&$grid)
{
    $seenElves   = [];
    $seenGoblins = [];

    $sizeY = count($grid);
    $sizeX = count($grid[0]);

    for ($y = 0; $y < $sizeY; $y++) {
        for ($x = 0; $x < $sizeX; $x++) {
            /** @var unit|string $unit */
            $unit = $grid[$y][$x];
            if (! $unit instanceof unit) {
                continue;
            }

            if ($unit instanceof elf) {
                if (isset($seenElves[$unit->getId()])) {
                    continue;
                }
                $seenElves[$unit->getId()] = $unit;
                $unit->move($grid);
                $unit->attack($grid);
                if (goblin::$allUnits === []) {
                    return false;
                }
            }
            if ($unit instanceof goblin) {
                if (isset($seenGoblins[$unit->getId()])) {
                    continue;
                }
                $seenGoblins[$unit->getId()] = $unit;
                $unit->move($grid);
                $unit->attack($grid);
                if (elf::$allUnits === []) {
                    return false;
                }
            }
        }
    }
    return true;
}


$grid = [];
foreach (file('in.txt') as $y => $row) {
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

$tick = 0;

/* */

while (tick($grid)) {
    $tick++;
    printGrid($grid);
    #usleep(50000);
    echo $tick, "\n";
}

//$tick++;

if ([] === goblin::$allUnits) {
    echo "\nelves won after round ", $tick, "\nscore: ";
    $score = 0;
    foreach (elf::$allUnits as $elf) {
        $score += $elf->getHitpoints();
    }
    echo $score * $tick;
}

if ([] === elf::$allUnits) {
    echo "\ngoblins won after round ", $tick, "\nscore: ";
    $score = 0;
    foreach (goblin::$allUnits as $elf) {
        $score += $elf->getHitpoints();
    }
    echo $score * $tick;
}

// print_r(goblin::$allUnits);

/* */