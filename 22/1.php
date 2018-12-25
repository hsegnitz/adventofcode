<?php

class map
{
    /** @var int */
    protected $maxX;

    /** @var int */
    protected $maxY;

    /** @var int */
    protected $depth;

    /** @var int[][] */
    protected $map = [];

    /** @var int[] */
    protected $erosionLevelCache = [];

    /** @var int[] */
    protected $geoIndexCache = [];

    /**
     * map constructor.
     *
     * @param int $maxX
     * @param int $maxY
     * @param int $depth
     */
    public function __construct($maxX, $maxY, $depth)
    {
        $this->maxX  = $maxX;
        $this->maxY  = $maxY;
        $this->depth = $depth;
    }

    public function build()
    {
        for ($y = 0; $y <= $this->maxY; $y++) {
            $this->map[$y] = [];
            for ($x = 0; $x <= $this->maxX; $x++) {
                $this->map[$y][$x] = $this->erosionLevel($x, $y) % 3;
            }
        }
    }

    /**
     * @param  int $x
     * @param  int $y
     * @return int
     */
    private function geoIndex($x, $y)
    {
        $key = "{$x}x{$y}";
        if (isset($this->geoIndexCache[$key])) {
            return $this->geoIndexCache[$key];
        }

        if ($x === 0 && $y === 0) {
            return 0;
        }

        if ($x === $this->maxX && $y === $this->maxY) {
            return 0;
        }

        if ($y === 0) {
            return $x * 16807;
        }

        if ($x === 0) {
            return $y * 48271;
        }

        $geoIndex = $this->erosionLevel($x-1, $y) * $this->erosionLevel($x, $y-1);
        $this->geoIndexCache[$key] = $geoIndex;
        return $geoIndex;
    }

    /**
     * @param  int $x
     * @param  int $y
     * @return int
     */
    private function erosionLevel($x, $y)
    {
        $key = "{$x}x{$y}";
        if (isset($this->erosionLevelCache[$key])) {
            return $this->erosionLevelCache[$key];
        }

        $erosionLevel = ($this->geoIndex($x, $y) + $this->depth) % 20183;
        $this->erosionLevelCache[$key] = $erosionLevel;
        return $erosionLevel;
    }

    public function sum()
    {
        $sum = 0;
        foreach ($this->map as $row) {
            $sum += array_sum($row);
        }

        return $sum;
    }

    public function printMap()
    {
        $out = '';
        foreach ($this->map as $row) {
            $out .= implode('', $row) . "\n";
        }

        echo str_replace([0,1,2], ['.', '=', '|'], $out);
    }
}


$map = new map(11, 718, 11739);
$map->build();
$map->printMap();
echo $map->sum();

/*$map = new map(10, 10, 510);
$map->build();
$map->printMap();
echo $map->sum();
*/