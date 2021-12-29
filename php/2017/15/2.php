<?php

$startTime = microtime(true);

class AocGenerator2 {
    private const MOD = 2147483647;
    public function __construct(
        private int $factor,
        private int $current,
        private int $checkMod,
    ) {}

    public function generate(): int
    {
        do {
            $this->current = ($this->current * $this->factor) % self::MOD;
        } while ($this->current % $this->checkMod !== 0);

        return $this->current;
    }

}

/*     * /
$genA = new AocGenerator2(
    16807,
    65,
    4,
);

$genB = new AocGenerator2(
    48271,
    8921,
    8,
);
/*     */

/*     */
$genA = new AocGenerator2(
    16807,
    289,
    4,
);

$genB = new AocGenerator2(
    48271,
    629,
    8,
);
/*     */



$count = 0;

for ($i = 0; $i < 5000000; $i++) {
    if ($genA->generate() % 65536 === $genB->generate() % 65536) {   //  65536 == 2^16 -- short for "last 16 bits similar" --- should be a lot faster than converting to binary string first.
        ++$count;
    }
}

echo $count;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


