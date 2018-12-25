<?php

class heap extends SplHeap
{
    protected function compare($a, $b): int
    {
        if ($b['time'] > $a['time']) {
            return 1;
        }

        if ($b['time'] < $a['time']) {
            return -1;
        }

        if ($b['x'] > $a['x']) {
            return 1;
        }

        if ($b['x'] < $a['x']) {
            return -1;
        }

        if ($b['y'] > $a['y']) {
            return 1;
        }

        if ($b['y'] < $a['y']) {
            return -1;
        }

        if ($b['tool'] > $a['tool']) {
            return 1;
        }

        if ($b['tool'] < $a['tool']) {
            return -1;
        }

        return 0;
    }
}

class map
{
    const NEITHER = 0;
    const TORCH   = 1;
    const CLIMB   = 2;

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

    /** @var heap */
    protected $heap;

    /** @var "{$x}x{$y}_{$tool}" => distance */
    protected $visited = [
        '0x0_1' => 0,
    ];

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

        $this->heap = new heap();
        $this->heap->insert(['time' => 0, 'x' => 0, 'y' => 0, 'tool' => self::TORCH]);

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

    private function visitNext($time, $x, $y, $equipment)
    {
        $nextSteps = [
            ['x' => $x + 1, 'y' => $y],
            ['x' => $x - 1, 'y' => $y],
            ['x' => $x    , 'y' => $y + 1],
            ['x' => $x    , 'y' => $y - 1],
        ];

        foreach ($nextSteps as $step) {
            if ($step['x'] < 0 || $step['y'] < 0) { // we hit solid rock.
                continue;
            }

            if ($this->erosionLevel($step['x'], $step['y']) % 3 === $equipment) { // wrong equipment
                continue;
            }

            $key = "{$step['x']}x{$step['y']}_{$equipment}";

            if (isset($this->visited[$key]) && $this->visited[$key] <= $time) {  // a faster - or at least similar - way there is
                continue;
            }
            $this->visited[$key] = $time;
            $this->heap->insert(['time' => $time, 'x' => $step['x'], 'y' => $step['y'], 'tool' => $equipment]);
        }
    }

    /**
     * @return int
     */
    public function walk()
    {
        while (true) {
            $startingPos = $this->heap->extract();
            if ($startingPos['x'] === $this->maxX && $startingPos['y'] === $this->maxY && $startingPos['tool'] === self::TORCH) {
                return $startingPos['time'];
            }

            // trying next square with same equipment
            $this->visitNext($startingPos['time'] + 1, $startingPos['x'], $startingPos['y'], $startingPos['tool']);

            // trying next squares with the only other equipment we can use in this current place (might fail in visitNext but we don't care.
            $terrain = $this->erosionLevel($startingPos['x'], $startingPos['y']) % 3;
            $currentTool = $startingPos['tool'];
            $newTool = 3 - $currentTool - $terrain;
            $this->visitNext($startingPos['time'] + 8, $startingPos['x'], $startingPos['y'], $newTool);
        }
    }
}

/* */
$map = new map(11, 718, 11739);
echo $map->walk(), "\n";
/* */


/* * /
$map = new map(10, 10, 510);
echo $map->walk();
/* */
