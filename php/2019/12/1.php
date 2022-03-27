<?php

$startTime = microtime(true);

require_once __DIR__ . '/../../common/math.php';

class Moon {
    private int $vX = 0;
    private int $vY = 0;
    private int $vZ = 0;

    public function __construct(private int $posX, private int $posY, private int $posZ)
    {}

    public function getPosX():int {
        return $this->posX;
    }

    public function getPosY():int {
        return $this->posY;
    }

    public function getPosZ():int {
        return $this->posZ;
    }

    public function gravity(Moon $otherMoon): void
    {
        if ($this->posX > $otherMoon->getPosX()) {
            --$this->vX;
        } else if ($this->posX < $otherMoon->getPosX()) {
            ++$this->vX;
        }

        if ($this->posY > $otherMoon->getPosY()) {
            --$this->vY;
        } else if ($this->posY < $otherMoon->getPosY()) {
            ++$this->vY;
        }

        if ($this->posZ > $otherMoon->getPosZ()) {
            --$this->vZ;
        } else if ($this->posZ < $otherMoon->getPosZ()) {
            ++$this->vZ;
        }
    }

    public function tick(): void
    {
        $this->posX += $this->vX;
        $this->posY += $this->vY;
        $this->posZ += $this->vZ;
    }

    public function getPotential(): int
    {
        return abs($this->posX) + abs($this->posY) + abs($this->posZ);
    }

    public function getKineticEnergy(): int {
        return abs($this->vX) + abs($this->vY) + abs($this->vZ);
    }

    public function getTotalEnergy(): int
    {
        return $this->getKineticEnergy() * $this->getPotential();
    }

    public function __toString(): string
    {
        return "coord(" . $this->posX . "," . $this->posY . "," . $this->posZ
            . ") vel(" . $this->vX . "," . $this->vY . "," . $this->vZ
            . ") " . $this->getPotential();
    }
}


class Solver {

    public function __construct()
    {
        /** @var Moon[] $moons */
        $moons = $this->realMoons();

        for ($i = 0; $i < 1000; $i++) {
            for ($a = 0; $a < 4; $a++) {
                for ($b = 0; $b < 4; $b++) {
                    if ($a === $b) {
                        continue;
                    }
                    $moons[$a]->gravity($moons[$b]);
                }
            }

            $sum = 0;
            foreach ($moons as $moon) {
                $moon->tick();
                $sum += $moon->getTotalEnergy();
            }
            echo $sum, "\n";
        }

    }

    private function demoMoons1(): array
    {
        return [
            new Moon(-1,   0,  2),
            new Moon( 2, -10, -7),
            new Moon( 4,  -8,  8),
            new Moon( 3,   5, -1),
        ];
    }

    private function demoMoons2(): array
    {
        return [
            new Moon(-8, -10,  0),
            new Moon( 5,   5, 10),
            new Moon( 2,  -7,  3),
            new Moon( 9,  -8, -3),
        ];
    }

    private function realMoons(): array
    {
        return [
            new Moon( -4,   3, 15),
            new Moon(-11, -10, 13),
            new Moon(  2,   2, 18),
            new Moon(  7,  -1,  0),
        ];
    }
}



$solver = new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
