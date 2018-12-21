<?php

class room
{
    private static $instanceCount = 0;
    private static $minX = 0;
    private static $minY = 0;
    private static $maxX = 0;
    private static $maxY = 0;

    /** @var room[][] */
    private static $map  = [];

    private $x;

    private $y;

    /** @var int */
    private $id;

    /** @var room */
    private $north;

    /** @var room */
    private $east;

    /** @var room */
    private $south;

    /** @var room */
    private $west;

    /**
     * room constructor.
     *
     * @param $x
     * @param $y
     */
    public function __construct($x, $y)
    {
        $this->id = self::$instanceCount++;
        $this->x = $x;
        $this->y = $y;

        if (isset(self::$map[$y])) {
            if (isset(self::$map[$y][$x])) {
                throw new RuntimeException('trying to recreate a room -- this is not the matrix!');
            }
            self::$map[$y][$x] = $this;
        } else {
            self::$map[$y] = [
                $x => $this,
            ];
        }

        self::$maxX = max(self::$maxX, $this->x);
        self::$maxY = max(self::$maxY, $this->y);
        self::$minX = min(self::$minX, $this->x);
        self::$minY = min(self::$minY, $this->y);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return room
     */
    public function getNorth()
    {
        return $this->north;
    }

    /**
     * @param room $north
     */
    public function setNorth($north)
    {
        $this->north = $north;
        if ($north->getSouth() instanceof room) {
            return;
        }
        $north->setSouth($this);
    }

    /**
     * @return room
     */
    public function getEast()
    {
        return $this->east;
    }

    /**
     * @param room $east
     */
    public function setEast($east)
    {
        $this->east = $east;
        if ($east->getWest() instanceof room) {
            return;
        }
        $east->setWest($this);
    }

    /**
     * @return room
     */
    public function getSouth()
    {
        return $this->south;
    }

    /**
     * @param room $south
     */
    public function setSouth($south)
    {
        $this->south = $south;
        if ($south->getNorth() instanceof room) {
            return;
        }
        $south->setNorth($this);
    }

    /**
     * @return room
     */
    public function getWest()
    {
        return $this->west;
    }

    /**
     * @param room $west
     */
    public function setWest($west)
    {
        $this->west = $west;
        if ($west->getEast() instanceof room) {
            return;
        }
        $west->setEast($this);
    }

    public static function printMap()
    {
        for ($y = self::$minY; $y <= self::$maxY; $y++) {
            // above -- only if first row
            if ($y === self::$minY) {
                for ($x = self::$minX; $x <= self::$maxX; $x++) {
                    if ($x === self::$minX) {
                        echo '#';
                    }
                    echo '##';
                }
                echo "\n";
            }

            // room line
            for ($x = self::$minX; $x <= self::$maxX; $x++) {
                if ($x === self::$minX) {
                    echo '#';
                }

                if (isset(self::$map[$y][$x]) && self::$map[$y][$x] instanceof room) {
                    echo self::$map[$y][$x]->getId() === 0 ? 'X' : '.';
                } else {
                    echo '?';
                }

                if (isset(self::$map[$y][$x]) && self::$map[$y][$x]->getEast() instanceof room) {
                    echo '|';
                } else {
                    echo '#';
                }
            }
            echo "\n";

            // below
            for ($x = self::$minX; $x <= self::$maxX; $x++) {
                if ($x === self::$minX) {
                    echo '#';
                }

                if (isset(self::$map[$y][$x]) && self::$map[$y][$x]->getSouth() instanceof room) {
                    echo '-';
                } else {
                    echo '#';
                }
                echo '#';
            }
            echo "\n";
        }
    }

    /**
     * @param string $in
     */
    public function walk($in)
    {
        switch ($in[0]) {
            case '$':
                return;
            case 'N':
                if (! $this->getNorth() instanceof room) {
                    $nextRoom = new room($this->x, $this->y - 1);
                    $this->setNorth($nextRoom);
                }
                $this->getNorth()->walk(substr($in, 1));
                break;
            case 'E':
                if (! $this->getEast() instanceof room) {
                    $nextRoom = new room($this->x +1, $this->y);
                    $this->setEast($nextRoom);
                }
                $this->getEast()->walk(substr($in, 1));
                break;
            case 'S':
                if (! $this->getSouth() instanceof room) {
                    $nextRoom = new room($this->x, $this->y + 1);
                    $this->setSouth($nextRoom);
                }
                $this->getSouth()->walk(substr($in, 1));
                break;
            case 'W':
                if (! $this->getWest() instanceof room) {
                    $nextRoom = new room($this->x - 1, $this->y);
                    $this->setWest($nextRoom);
                }
                $this->getWest()->walk(substr($in, 1));
                break;
            case '(':
                $posClosingBrace = $this->findClosingParanthesis($in);
                $branches = $this->splitWithBraces(substr($in, 1, $posClosingBrace-1)); // FIXME: leave (...|...) intact ;)
                foreach ($branches as $branch) {
                    $this->walk($branch . substr($in, $posClosingBrace+1));
                }
                break;
            default:
                throw new RuntimeException('Go fuck yourself with your ' . $in[0]);
        }
    }

    /**
     * @param  string   $in
     * @return string[]
     */
    private function splitWithBraces($in)
    {
        $pattern = '/\(([^\(\)]+)\)/';
        while (true) {
            $newIn = preg_replace_callback($pattern, function ($matches) {return '[' . str_replace('|', '-', $matches[1]) . ']';}, $in);
            if ($newIn === $in) {
                break;
            }
            $in = $newIn;
        }

        $out = [];
        foreach (explode('|', $newIn) as $row) {
            $out[] = str_replace(['[', '-', ']'], ['(', '|', ')'], $row);
        }

        return $out;
    }

    private function findClosingParanthesis($in)
    {
        $count = 0;
        for ($i = 0; $i < strlen($in); $i++) {
            if ($in[$i] === '(') {
                ++$count;
            } elseif ($in[$i] === ')') {
                --$count;
            }

            if ($count === 0) {
                return $i;
            }
        }
    }
}

$in = file_get_contents('in.txt');

$root = new room(0 ,0);
$root->walk(substr($in, 1));

room::printMap();
