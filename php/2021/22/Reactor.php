<?php

class Reactor
{
    /** @var Cube[] */
    private array $cubes = [];

    public function add(Cube $cube): void
    {
        foreach ($this->cubes as $thisCube) {
            if ($thisCube->fullyContains($cube)) {
                return;
            }
            if ($thisCube->intersectsWith($cube)) {
                throw new RuntimeException('Nobody expects cubes to overlap, right?');
            }
        }
        $this->cubes[] = $cube;
    }

    public function remove(Cube $cube): void
    {
        $newCubes = [];
        foreach ($this->cubes as $thisCube) {
            if (!$cube->intersectsWith($thisCube)) {
                $newCubes[] = $thisCube;
                continue;
            }

            if ($cube->fullyContains($thisCube)) {
                continue;
            }

        }
        $this->cubes = $newCubes;
    }

    public function numberOfOns(): int
    {
        $sum = 0;
        foreach ($this->cubes as $cube) {
            $sum += $cube->volume();
        }
        return $sum;
    }
}

