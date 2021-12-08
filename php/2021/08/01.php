<?php

$startTime = microtime(true);

#$input = file('./example1.txt');
$input = file('./in.txt');

$numUnique = 0;
foreach ($input as $line) {
    [$in, $out] = explode(' | ', $line);
    $outSplit = explode (' ', $out);
    foreach($outSplit as $outSequence) {
        switch (strlen(trim($outSequence))) {
            case 2:
            case 3:
            case 4:
            case 7:
                ++$numUnique;
        }
    }
}

echo $numUnique;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


