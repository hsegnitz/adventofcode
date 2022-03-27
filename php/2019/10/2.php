<?php

$startTime = microtime(true);

require_once __DIR__ . '/../../common/math.php';

class Solver {

    private array $map = [];

    public const LASER_X = 29;
    public const LASER_Y = 28;

    private array $deathRow = [];

    public function __construct()
    {
        $this->readMap();

        $count = 0;
        while (true) {
            foreach ($this->deathRow as &$sub) {
                if (count($sub) > 0) {
                    /** @var Asteroid $first */
                    $first = array_shift($sub);
                    echo $count++, ": ", $first->getPosX(), "x", $first->getPosY(), "\n";
                    if ($count === 200) {
                        echo $first->getPosX() * 100 + $first->getPosY();
                        return;
                    }
                }
            }
        }
    }

    private function readMap(): void
    {
        $input = file(__DIR__ . '/in.txt', FILE_IGNORE_NEW_LINES);
        foreach ($input as $line) {
            $this->map[] = str_split($line);
        }

        foreach ($this->map as $rowNum => $row) {
            foreach ($row as $colNum => $col) {
                if ($col !== '#') {
                    continue;
                }
                if ($rowNum === self::LASER_Y && $colNum === self::LASER_X) {
                    continue;
                }

                $ast = new Asteroid($colNum, $rowNum);

                if (!isset($this->deathRow[$ast->getAngle()])) {
                    $this->deathRow[$ast->getAngle()] = [];
                }
                $this->deathRow[$ast->getAngle()][$ast->getDistance()] = $ast;

/*                if (!isset($this->deathRow[$ast->getAngle()][$ast->getDistance()])) {
                    $this->deathRow[$ast->getAngle()][$ast->getDistance()] = [];
                }
                $this->deathRow[$ast->getAngle()][$ast->getDistance()][] = $ast;
*/
            }
        }

        foreach ($this->deathRow as &$row) {
            ksort($row);
        }
        ksort ($this->deathRow);
    }
}

class Asteroid {
    private int $distance;  // taxicab geometry!
    private float $angle;

    public function __construct(private int $posX, private int $posY) {
        $this->distance = common\math::taxiDistance(Solver::LASER_X, $posX, Solver::LASER_Y, $posY);
        $this->angle();
    }

    private function angle(): void {
#        $radians = atan2((), ($this->posX - Solver::LASER_X));
#        $this->angle = $radians;
#        return;
#        $radians = ($radians + (2.0 * M_PI)) % (2.0 * M_PI);
#        $this->angle = ($radians + (M_PI / 2.0)) % (2.0 * M_PI);
        $x = $this->posX - Solver::LASER_X;
        $y = $this->posY - Solver::LASER_Y;
        $angle = rad2deg(atan2($y, $x));

        $angle += 90;

        if ($angle < 0) {
            $angle += 360;
        }

        $this->angle = $angle;
    }

    public function getPosX(): int
    {
        return $this->posX;
    }

    public function getPosY(): int
    {
        return $this->posY;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getAngle(): string
    {
        return number_format($this->angle, 6);
    }
}

$solver = new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
