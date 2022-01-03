<?php

$startTime = microtime(true);

#$input = file_get_contents('./demo2.txt');
$input = file_get_contents('./in.txt');

$input = explode("\n", $input);
$particles = [];

foreach ($input as $id => $row) {
    $particles[] = Particle::fromString($id, $row);
}


class Particle
{
    public function __construct(private int $id, private array $coords, private array $velocity, private array $acceleration)
    {}

    public static function fromString(int $id, string $input): Particle
    {
        //p=< 3,0,0>, v=< 2,0,0>, a=<-1,0,0>
        if (preg_match('/p=<([- 0-9]+),([- 0-9]+),([- 0-9]+)>,\s*v=<([- 0-9]+),([- 0-9]+),([- 0-9]+)>,\s*a=<([- 0-9]+),([- 0-9]+),([- 0-9]+)>/', $input, $out)) {
            return new Particle(
                $id,
                [$out[1], $out[2], $out[3]],
                [$out[4], $out[5], $out[6]],
                [$out[7], $out[8], $out[9]],
            );
        }
        throw new InvalidArgumentException('cannot parse input ' . $input);
    }

    public function tick(): void
    {
        $this->applyAcceleration();
        $this->applyVelocity();
    }

    private function applyAcceleration(): void
    {
        $this->add($this->velocity, $this->acceleration);
    }

    private function applyVelocity(): void
    {
        $this->add($this->coords, $this->velocity);
    }

    private function add(array &$receive, array $send): void
    {
        foreach ($send as $num => $val) {
            $receive[$num] += $val;
        }
    }

    public function getDistanceFromRoot(): int
    {
        return abs($this->coords[0]) + abs($this->coords[1]) + abs($this->coords[2]);
    }

    public function getCoordsString(): string
    {
        return implode(',', $this->coords);
    }

    public function getId(): int
    {
        return $this->id;
    }
}

for ($tick = 0; $tick < 1000; $tick++) {
    $newParticles = [];
    foreach ($particles as $particle) {
        $particle->tick();
        $newParticles[$particle->getCoordsString()][] = $particle;
    }

    $particles = [];
    foreach ($newParticles as $list) {
        if (count($list) > 1) {
            continue;
        }
        $particles[] = $list[0];
    }

    echo "{$tick}: ", count($particles), "\n";
}




echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
