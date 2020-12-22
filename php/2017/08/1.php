<?php

$startTime = microtime(true);

$input = file(__DIR__ . '/in.txt');

$registers = [];
foreach ($input as $line) {
    [$registerToModify, $incDec, $diff, $if, $registerToCheck, $comparison, $valueToCheck] = explode(" ", trim($line));
    if ($if !== 'if') {
        throw new RuntimeException('parse error');
    }

    $registerValue = $registers[$registerToCheck] ?? ($registers[$registerToCheck] = 0);
    if (!isset($registers[$registerToModify])) {
        $registers[$registerToModify] = 0;
    }

    $diff = (int)$diff;
    if ($incDec === 'dec') {  // so that we only have to add further on.
        $diff *= -1;
    }

    switch ($comparison) {
        case '<':
            if ($registerValue < (int)$valueToCheck) {
                $registers[$registerToModify] += $diff;
            }
            break;
        case '>':
            if ($registerValue > (int)$valueToCheck) {
                $registers[$registerToModify] += $diff;
            }
            break;
        case '<=':
            if ($registerValue <= (int)$valueToCheck) {
                $registers[$registerToModify] += $diff;
            }
            break;
        case '>=':
            if ($registerValue >= (int)$valueToCheck) {
                $registers[$registerToModify] += $diff;
            }
            break;
        case '==':
            if ($registerValue == (int)$valueToCheck) {
                $registers[$registerToModify] += $diff;
            }
            break;
        case '!=':
            if ($registerValue != (int)$valueToCheck) {
                $registers[$registerToModify] += $diff;
            }
            break;
        default:
            throw new RuntimeException('WTF?! ' . $comparison);
    }
}

echo max($registers), "\n";


echo "total time: ", (microtime(true) - $startTime), "\n";

