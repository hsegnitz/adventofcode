<?php

$startTime = microtime(true);

require __DIR__ . '/Tile.php';

$rawInput = file_get_contents(__DIR__ . '/in.txt');

$tiles = [];
foreach (explode("\n\n", $rawInput) as $rawTile) {
    $tiles[] = new Tile($rawTile);
}

// to be smart: a border tile has one edge that is not found anywhere -- flipped or regular!
// AND edge tiles have two unmatched ones.

// we deliberately check a -> b and then b -> a again, as we might need that for lookup later.
$matchesPerTile = [];
foreach ($tiles as $k1 => $tile1) {
$matchesPerTile[$k1] = [];
    foreach ($tiles as $k2 => $tile2) {
        if ($k1 === $k2) {
            continue;
        }
        if ($tile1->hasMatchingEdge($tile2)) {
            $matchesPerTile[$k1][] = $tile2;
        }
    }
}

$corners = [];
foreach ($matchesPerTile as $tileK => $matchingTiles) {
    if (count($matchingTiles) === 2) {
        $corners[] = $tiles[$tileK]->getId();
    }
}

print_r($corners);

echo $corners[0] * $corners[1] * $corners[2] * $corners[3];

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
