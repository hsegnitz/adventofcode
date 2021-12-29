<?php

$startTime = microtime(true);

class AocGenerator {
    private const MOD = 2147483647;
    public function __construct(
        private int $factor,
        private int $current,
    ) {}

    public function generate(): int
    {
        $this->current = ($this->current * $this->factor) % self::MOD;
        return $this->current;
    }

}

/*     * /
$genA = new AocGenerator(
    16807,
    65,
);

$genB = new AocGenerator(
    48271,
    8921,
);
/*     */

/*     */
$genA = new AocGenerator(
    16807,
    289,
);

$genB = new AocGenerator(
    48271,
    629,
);
/*     */



$count = 0;

for ($i = 0; $i < 40000000; $i++) {
    if ($genA->generate() % 65536 === $genB->generate() % 65536) {   //  65536 == 2^16 -- short for "last 16 bits similar" --- should be a lot faster than converting to binary string first.
        ++$count;
    }
}

echo $count;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


