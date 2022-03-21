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

echo "Sum ", $sum, "\n";

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
