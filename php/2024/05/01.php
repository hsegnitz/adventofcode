<?php

$start = microtime(true);


#$file = file_get_contents('example.txt');
$file = file_get_contents('input.txt');

$sum1 = $sum2 = 0;

[$rawChecks, $rawPages] = explode("\n\n", $file);
$rawChecks = explode("\n", $rawChecks);
$rawPages = explode("\n", $rawPages);

$checks = $manuals = [];
foreach ($rawChecks as $check) {
    $checks[] = explode("|", $check);
}
foreach ($rawPages as $pageList) {
    $manuals[] = explode(",", $pageList);
}

function isValid(array $pages, array $checks): bool
{
    foreach ($checks as $check) {
        // find pos of both numbers
        $leftPos = array_search($check[0], $pages);
        $rightPos = array_search($check[1], $pages);

        // if pos of right number is before the left, abort
        if ($leftPos === false || $rightPos === false) {
            continue;
        }
        if ($leftPos > $rightPos) {
            return false;
        }
    }
    return true;
}

$invalidManuals = [];
foreach ($manuals as $pages) {
    if (isValid($pages, $checks)) {
        $sum1 += $pages[(count($pages)-1)/2];
    } else {
        $invalidManuals[] = $pages;
    }
}

foreach ($invalidManuals as $pages) {
    usort($pages, function ($a, $b) use ($checks): int {
        foreach ($checks as $check) {
            if ($check[0] === $a && $check[1] === $b) {
                return -1;
            }
            if ($check[0] === $b && $check[1] === $a) {
                return 1;
            }
        }
        return 0;
    });

    $sum2 += $pages[(count($pages)-1)/2];
}



echo "Part 1: ", $sum1, "\nPart 2: ", $sum2, "\n";

echo microtime(true) - $start;
echo "\n";
