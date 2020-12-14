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
        foreach (computeMemoryAddresses($mask, (int)$address) as $newAddress) {
            $registers[(int)$newAddress] = (int)$value;
        }
    }
}

function computeMemoryAddresses(string $mask, int $address): array
{
    $addressAsString = base_convert((string)$address, 10, 2);
    $addressAsString = str_pad($addressAsString, 36, '0', STR_PAD_LEFT);

    $addresses = [''];

    for ($i = 0; $i < 36; $i++) {
        if ($mask[$i] === '0') {
            foreach ($addresses as &$add) {
                $add .= $addressAsString[$i];
            }
            unset($add);
        }
        if ($mask[$i] === '1') {
            foreach ($addresses as &$add) {
                $add .= '1';
            }
            unset($add);
        }
        if ($mask[$i] === 'X') {
            $new = [];
            foreach ($addresses as $add) {
                $new[] = $add.'0';
                $new[] = $add.'1';
            }
            $addresses = $new;
        }
    }

    foreach ($addresses as &$add) {
        $add = base_convert($add, 2, 10);
    }

    return $addresses;
}





echo array_sum($registers);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
