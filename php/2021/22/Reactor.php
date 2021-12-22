<?php

class Reactor
{
    /** @var Cube[] */
    private array $cubes = [];

    // Strategy:
    // we reduce our new cube to an arbitrary set of smaller cubes by repeatedly removing the
    // portions we already have in $this->cubes.
    // this should work without the cursed recursion TM
    public function add(Cube $cube): void
    {
        $incomingCubes = [$cube];
        foreach ($this->cubes as $thisCube) {
            $newCubes = [];
            foreach ($incomingCubes as $incubus) {
                if ($thisCube->fullyContains($incubus)) {
                    continue;
                }

                if (!$incubus->intersectsWith($thisCube)) {
                    $newCubes[] = $incubus;
                    continue;
                }

                foreach ($incubus->subtract($thisCube) as $tempCube) {
                    $newCubes[] = $tempCube;
                }
            }
            $incomingCubes = $newCubes;
        }

        if ($incomingCubes !== []) {
            foreach ($incomingCubes as $inc) {
                $this->cubes[] = $inc;
            }
        }
    }

    /**
     * remove all points within $cube from the collective - if they are already set.
     */
    public function remove(Cube $cube): void
    {
        $newCubes = [];
        foreach ($this->cubes as $thisCube) {
            //
            if (!$cube->intersectsWith($thisCube)) {
                $newCubes[] = $thisCube;
                continue;
            }

            if ($cube->fullyContains($thisCube)) {
                continue;
            }

            $subCubes = $thisCube->subtract($cube);
            foreach ($subCubes as $sub) {
                $newCubes[] = $sub;
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

