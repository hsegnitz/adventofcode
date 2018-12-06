<?php

$input = file('in.txt');

$coordinates = [];
$counts = [];
foreach ($input as $row) {
    $split = explode(',', $row);
    $coordinates[] = [
        'x' => (int)$split[0],
        'y' => (int)$split[1],
    ];
    $counts[] = 0;
}
$counts['x'] = 0;


$map = [];

for ($x = 0; $x < 500; $x++) {
    $map[$x] = [];
    for ($y = 0; $y < 500; $y++) {
        $distances = [];
        foreach ($coordinates as $id => $touple) {
            $tdst = taxiDistance($x, $y, $touple['x'], $touple['y']);
            if ($tdst !== 0) {
                $distances[$id] = $tdst;
            }
        }
        arsort($distances);
        list($aId => $aDist, $bId => $bDist) = $distances;

        $map[$x][$y] = $minCandidate;
    }
}

// find edges == infinites?!
$edgeNumbers = [];
for ($x = 0; $x < 500; $x++) {
    $edgeNumbers[$map[$x][0]] = true;
    $edgeNumbers[$map[$x][499]] = true;
}

for ($y = 0; $y < 500; $y++) {
    $edgeNumbers[$map[0][$y]] = true;
    $edgeNumbers[$map[499][$y]] = true;
}

#print_r($edgeNumbers);


// count

foreach ($map as $x) {
    foreach ($x as $y) {
        ++$counts[$y];
    }
}

arsort($counts);

foreach ($counts as $id => $count) {
    if (isset($edgeNumbers[$id])) {
        continue;
    }
    echo $id, ' => ', $count, "\n";
}









function taxiDistance($leftA, $topA, $leftB, $topB)
{
    return abs($leftA - $leftB) + abs($topA - $topB);
}

