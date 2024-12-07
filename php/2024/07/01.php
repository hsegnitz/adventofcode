<?php

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;

foreach ($lines as $line) {
    [$target, $operands] = explode(': ', $line);
    $operands = explode(' ', $operands);

    if (canBeSolved((int)$target, $operands)) {
        $sum += (int)$target;
    }
}

function canBeSolved (int $target, array $operands): bool
{
    foreach (permute([], $operands) as $result) {
#        echo $result, "\n";
        if ($result === $target) {
            return true;
        }
    }
    return false;
}

function permute(array $stack, array $remainingOperands): array
{
    if (count($remainingOperands) > 0) {
        $operand = array_shift($remainingOperands);
        if ($stack === []) {
            $stack = [$operand];
            return permute($stack, $remainingOperands);
        }

        $newStack = [];
        foreach ($stack as $leftOperand) {
            $newStack[] = $leftOperand + $operand;
            $newStack[] = $leftOperand * $operand;
        }
        return permute($newStack, $remainingOperands);
    }
    return $stack;
}

echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";
