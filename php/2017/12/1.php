<?php

$startTime = microtime(true);

$pipes = [];
foreach (file(__DIR__ . '/in.txt') as $num => $rawLine) {
    if (preg_match('/(\d+) <-> ([\d, ]+)/', $rawLine, $out)) {
        $pipes[$out[1]] = explode(', ', $out[2]);
    } else {
        throw new RuntimeException('WTF?! ' . $rawLine);
    }
}

#print_r($pipes);

function findClosedCircleOf(int $targetId, array $pipes): array
{
    $targetPipes = [
        $targetId => true,
    ];
    $oldTargetPipes = [];
    while ($targetPipes !== $oldTargetPipes) {
        $oldTargetPipes = $targetPipes;
        foreach (array_keys($oldTargetPipes) as $id) {
            foreach ($pipes[$id] as $target) {
                $targetPipes[$target] = true;
            }
        }
    }

    $targetPipes = array_keys($targetPipes);
    sort($targetPipes);
    return $targetPipes;
}

$targetPipes = findClosedCircleOf(0, $pipes);
echo implode(', ', $targetPipes), "\n";
echo count($targetPipes), "\n";

$allClosedCircles = [];
foreach (array_keys($pipes) as $pipeId) {
    $allClosedCircles[] = findClosedCircleOf($pipeId, $pipes);
}

$unique = array_unique($allClosedCircles, SORT_REGULAR);

echo count($unique), "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";

