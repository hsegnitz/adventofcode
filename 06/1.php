<?php

$input = file('in.txt');
//$input = file('small.txt');

$size = 500;
//$size = 10;

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

for ($x = 0; $x < $size; $x++) {
    $map[$x] = [];
    for ($y = 0; $y < $size; $y++) {
        $distances = [];
        foreach ($coordinates as $id => $touple) {
            $distances[$id] = taxiDistance($x, $y, $touple['x'], $touple['y']);
        }
        asort($distances);
        $aId       = key($distances);
        $aDistance = current($distances);
        $bDistance = next($distances);

        #echo $bDistance; die();

        if ($aDistance === $bDistance) {
            $map[$x][$y] = 'x';
        } else {
            $map[$x][$y] = $aId;
        }
    }
}

// find edges == infinites?!
$edgeNumbers = [];
for ($x = 0; $x < $size; $x++) {
    $edgeNumbers[$map[$x][0]] = true;
    $edgeNumbers[$map[$x][$size-1]] = true;
}

for ($y = 0; $y < $size; $y++) {
    $edgeNumbers[$map[0][$y]] = true;
    $edgeNumbers[$map[$size-1][$y]] = true;
}

#print_r($edgeNumbers);


// count

foreach ($map as $x) {
    foreach ($x as $y) {
        ++$counts[$y];
    }
}

arsort($counts);

/*
for ($y = 0; $y < $size; $y++) {
    for ($x = 0; $x < $size; $x++) {
        echo $map[$x][$y], "\t";
    }
    echo "\n";
}
*/


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

