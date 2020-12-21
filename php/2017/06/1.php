<?php

$startTime = microtime(true);

$banks = explode("\t", file_get_contents(__DIR__ . '/demo.txt'));
$banks = array_map('intval', $banks);

$seen = [
    $hash = implode('|', $banks) => true,
];

$cycles = 0;
while (true) {
    $cycles++;

    $banks = distribute($banks);

    $hash = implode('|', $banks);
    if (isset($seen[$hash])) {
        break;
    }
    $seen[$hash] = true;
}

print_r($seen);

echo $cycles, "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";


function distribute (array $banks): array
{
    $numBanks = count($banks);
    $indexOfLargest = getIndexOfLargest($banks);
    $toSpread = $banks[$indexOfLargest];
    $banks[$indexOfLargest] = 0;

    $incrBy = (int)ceil($toSpread / $numBanks);

    if ($toSpread % $numBanks === 0) {
        foreach ($banks as &$value) {
            $value += $incrBy;
        }
        return $banks;
    }

    for ($i = $indexOfLargest + 1; $i <= $indexOfLargest + ($toSpread % $numBanks); $i++) {
        $banks[$i % $numBanks] += $incrBy;
    }

    for ($j = $i % $numBanks; $j <= $indexOfLargest; $j++) {
        $banks[$j] += $incrBy -1;
    }

    return $banks;
}

function getIndexOfLargest(array $banks): int
{
    $max = max($banks);
    foreach ($banks as $index => $value) {
        if ($value === $max) {
            return $index;
        }
    }
    throw new RuntimeException('This should only happen when you apply time travel during loop execution.');
}
