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

        $possibleMoves = [];
        $minDistance = PHP_INT_MAX;
        foreach ($this->freePointsAround($grid, $this->getX(), $this->getY()) as $possibleMove) {
            $minDistanceMove = PHP_INT_MAX;
            $moveAndDistance = $this->determineReachablePoints($grid, [$possibleMove], $minDistanceMove, $chosen);
            $minDistance = min($minDistanceMove, $minDistance);
            $possibleMoves[] = $moveAndDistance[0];
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
            $grid[$this->getX()]  [$this->getY()-1],
            $grid[$this->getX()]  [$this->getY()+1],
            $grid[$this->getX()-1][$this->getY()],
            $grid[$this->getX()+1][$this->getY()],
        ];

        $enemies = [];
        $lowestHp = PHP_INT_MAX;
        foreach ($adjacentTiles as $tile) {
            if ($tile instanceof unit && ! $tile instanceof self) {
                $lowestHp = min($lowestHp, $tile->getHitpoints());
                $enemies[] = $tile;
            }
        }

        if (count($enemies) === 0) {
            return;
        }

        usort($enemies, function (unit $a, unit $b) {
            if ($a->getHitpoints() < $b->getHitpoints()) {
                return 1;
            }
            if ($a->getHitpoints() < $b->getHitpoints()) {
                return -1;
            }
            if ($a->getY() < $b->getY()) {
                return 1;
            }
            if ($a->getY() < $b->getY()) {
                return -1;
            }
            if ($a->getX() < $b->getX()) {
                return 1;
            }
            if ($a->getX() < $b->getX()) {
                return -1;
            }
            return 0;
        });

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

    public function __construct($posX, $posY, $hp = null)
    {
        $this->hitPoints = $hp;
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

$enemies = [
    new elf(3, 2, 3),
    new elf(2, 3, 2),
    new elf(4, 3, 2),
    new elf(3, 4, 2),
];



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

print_r($enemies);