<?php

$startTime = microtime(true);

include __DIR__ . '/SpaceObject.php';

$input = file('in.txt', FILE_IGNORE_NEW_LINES);

$space = [];
$com = new SpaceObject("COM");
$space["COM"] = $com;

$allFound = false;
while ($allFound === false) {
    $allFound = true;
    foreach($input as $line) {
        $split = explode(")", $line);
        if (isset($space[$split[1]])) {
            continue;
        }

        if (isset($space[$split[0]])) {
            $so = new SpaceObject($split[1]);
            $space[$split[1]] = $so;
            $space[$split[0]]->addChild($so);
        } else {
            $allFound = false;
        }
    }
}

$sum = 0;
foreach ($space as $so) {
    $sum += $so->countParents();
}

echo "Sum (Part 1)", $sum, "\n";

function parentChain(SpaceObject $child): array {
    $cur = $child;
    $out = [];
    while($cur->getName() !== "COM") {
        $out[] = $cur->getName();
        $cur = $cur->getParent();
    }
    $out[] = "COM";

    return $out;
}


$me = $space["YOU"];
$meAddress = parentChain($me);

$santa = $space["SAN"];
$santaAddress = parentChain($santa);

$a = $b = '';

while ($a === $b) {
    $a = array_pop($meAddress);
    $b = array_pop($santaAddress);
}

echo "Steps (Part 2): ", (count($meAddress) + count($santaAddress));

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
