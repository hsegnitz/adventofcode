<?php

$startTime = microtime(true);

/** @var int[] $registers */
$registers = [];
$mask = ''; // no need to define a default mask, input starts with one!
foreach (file(__DIR__ .'/in.txt') as $line) {
    if (preg_match('/^mask = ([X10]+)/', $line, $out)) {
        $mask = $out[1];
        continue;
    }

    if (preg_match('/^mem\[(\d+)] = (\d+)/', $line, $out)) {
        [, $address, $value] = $out;
        $registers[(int)$address] = applyMaskToValue($mask, (int)$value);
    }
}

function applyMaskToValue(string $mask, int $value): int
{
    $valueAsString = base_convert((string)$value, 10, 2);
    $valueAsString = str_pad($valueAsString, 36, '0', STR_PAD_LEFT);

    for ($i = 0; $i < 36; $i++) {
        if ($mask[$i] === 'X') {
            continue;
        }
        $valueAsString[$i] = $mask[$i];
    }

    return (int)base_convert($valueAsString, 2, 10);
}



echo array_sum($registers);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
