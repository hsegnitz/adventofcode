<?php

$startTime = microtime(true);

require __DIR__ . '/Tile.php';

$rawInput = file_get_contents(__DIR__ . '/demo.txt');

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
$edges  = [];
foreach ($matchesPerTile as $tileK => $matchingTiles) {
    if (count($matchingTiles) === 2) {
        $corners[$tileK] = $tiles[$tileK];
        unset($tiles[$tileK]);
    }
    if (count($matchingTiles) === 3) {
        $edges[$tileK] = $tiles[$tileK];
        unset($tiles[$tileK]);
    }
}

// tiles is now only the center mass of 4-edge-matching tiles

#print_r($corners);

#echo count($edges);  // 4(0)?   !

// pick any corner, make it 0, 0
// find out which edges match, rotate so that they are r and b, use this as initial state
// go for the first row, find 10 more tiles and their rotation and flippiness to match the upper edge, then match corner tile
// etc.

// assemble image by returning the correct orientation and flip minus edges

// foreach over the lines and positions and apply three different regex
// when found replace the monster's pixels with Os

// count

$firstKey = array_key_first($corners);

$grid = [
    0 => [
        0 => $corners[$firstKey],
    ],
];

unset ($corners[$firstKey]);



echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
