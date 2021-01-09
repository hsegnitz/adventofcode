<?php

$startTime = microtime(true);

$pipes = [];
foreach (file(__DIR__ . '/demo.txt') as $num => $rawLine) {
    if (preg_match('/(\d+) <-> ([\d, ]+)/', $rawLine, $out)) {
        $pipes[$out[1]] = explode(', ', $out[2]);
    } else {
        throw new RuntimeException('WTF?! ' . $rawLine);
    }
}

#print_r($pipes);

$targetPipes = [
    0 => true,
];
$oldTargetPipes = [];
while ($targetPipes !== $oldTargetPipes) {
    $oldTargetPipes = $targetPipes;
    foreach ($oldTargetPipes as $id => $blubb) {
        foreach ($pipes[$id] as $target) {
            $targetPipes[$target] = true;
        }
    }
}

echo implode(', ', array_keys($targetPipes)), "\n";
echo count($targetPipes), "\n";
echo "total time: ", (microtime(true) - $startTime), "\n";

