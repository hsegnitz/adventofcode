<?php

$startTime = microtime(true);

require __DIR__ . '/Tile.php';

$rawInput = file_get_contents(__DIR__ . '/demo.txt');

$tiles = [];
foreach (explode("\n\n", $rawInput) as $rawTile) {
    $tile = new Tile($rawTile);
    $tiles[$tile->getId()] = $tile;
}

$edgeSize = sqrt(count($tiles));

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
            $matchesPerTile[$tile1->getId()][$tile2->getId()] = $tile2;
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

$firstKey = array_key_first($corners);

$grid = [
    0 => [
        0 => $corners[$firstKey],
    ],
];

unset ($corners[$firstKey]);


// find out which edges match

$topMatches = $leftMatches = false;
foreach ($matchesPerTile[$firstKey] as $tile) {
    $m = $grid[0][0]->findMatchingEdgesAndOrientation($tile);
    if ($m[0] === 't') {
        $topMatches = true;
    }
    if ($m[0] === 'l') {
        $leftMatches = true;
    }
}


// rotate so that they are r and b, use this as initial state

if ($topMatches && $leftMatches) {
    $grid[0][0]->setOrientation(Tile::ORIENTATION_BOTTOM);
} elseif ($leftMatches) {
    $grid[0][0]->setFlipped(true);
} elseif ($topMatches) {
    $grid[0][0]->setOrientation(Tile::ORIENTATION_RIGHT);
}


// go for the first row, find 10 more tiles and their rotation and flippiness to match the upper edge, then match corner tile
// match X times the right corner of the current one
for ($x = 0; $x < $edgeSize-2; $x++) {
    $cur = $grid[0][$x];
    /**
     * @var int $edgeKey
     * @var Tile $edgeTile
     */
    foreach ($matchesPerTile[$cur->getId()] as $edgeKey => $edgeTile) {
        if (!isset($edges[$edgeKey])) {
            continue; // because not an edge, we can save the effort!
        }

        $rightEdge = $cur->getAppliedRight();
        foreach ([false, true] as $flip) {
            $edgeTile->setFlipped($flip);
            foreach (Tile::ORIENTATIONS as $orientation) {
                $edgeTile->setOrientation($orientation);
                if ($rightEdge === $edgeTile->getAppliedLeft()) {
                    $grid[0][$x+1] = $edgeTile;
                    unset($edges[$edgeKey]);
                    break 3;
                }
            }
        }
    }
}

// add top right corner
$cur = $grid[0][$edgeSize-2];
foreach ($matchesPerTile[$cur->getId()] as $edgeKey => $edgeTile) {
    if (!isset($corners[$edgeKey])) {
        continue; // because not a corner, we can save the effort!
    }

    $rightEdge = $cur->getAppliedRight();
    foreach ([false, true] as $flip) {
        $edgeTile->setFlipped($flip);
        foreach (Tile::ORIENTATIONS as $orientation) {
            $edgeTile->setOrientation($orientation);
            if ($rightEdge === $edgeTile->getAppliedLeft()) {
                $grid[0][$edgeSize-1] = $edgeTile;
                unset($corners[$edgeKey]);
                break 3;
            }
        }
    }
}

// assemble all future rows by adding the only ones that can fit from their top layer
// brute force without doing extra stuff for edges,  TABLEFLIP
for ($y = 0; $y < $edgeSize -1; $y++) {
    for ($x = 0; $x < $edgeSize; $x++) {
       $cur = $grid[$y][$x];
        foreach ($matchesPerTile[$cur->getId()] as $edgeKey => $edgeTile) {
            if (!isset($edges[$edgeKey]) && !isset($corners[$edgeKey]) && !isset($tiles[$edgeKey])) {
                continue; // because not an edge, we can save the effort!
            }

            $bottomEdge = $cur->getAppliedBottom();
            foreach ([false, true] as $flip) {
                $edgeTile->setFlipped($flip);
                foreach (Tile::ORIENTATIONS as $orientation) {
                    $edgeTile->setOrientation($orientation);
                    if ($bottomEdge === $edgeTile->getAppliedTop()) {
                        $grid[$y+1][$x] = $edgeTile;
                        unset($edges[$edgeKey], $corners[$edgeKey], $tiles[$edgeKey]);
                        break 3;
                    }
                }
            }
        }
    }
}


//debug
foreach ($grid as $row) {
    foreach ($row as $tile) {
        echo $tile->getId(), " ";
    }
    echo "\n";
}


// assemble image by returning the correct orientation and flip minus edges
$bigGrid = [];
foreach ($grid as $row) {
    $rawArrays = [];
    foreach ($row as $tile) {
        $rawArrays[] = $tile->getCroppedAndAlignedContent();
    }

    for ($i = 0, $iMax = count($rawArrays[0]); $i < $iMax; $i++) {
        $line = [];
        foreach ($rawArrays as $rawArray) {
            // $line = array_merge($line, $rawArray[$i], [' ']);
            $line = array_merge($line, $rawArray[$i]);
        }
        $bigGrid[] = $line;
    }
    // $bigGrid[] = [];
}


/*
$bigGrid = flip($bigGrid);
$bigGrid = rotateLeft($bigGrid);
*/

//debug
foreach ($bigGrid as $row) {
    echo implode('', $row), "\n";
}
echo "\n";








function flip(array $grid): array
{
    $newCropped = [];
    foreach ($grid as $row) {
        $newCropped[] = array_reverse($row);
    }
    return $newCropped;
}

function rotateLeft(array $grid): array
{
    $new = [];
    $len = count($grid);

    for ($y = 0; $y < $len; $y++) {
        for ($x = 0; $x < $len; $x++) {
            $new[$y][$x] = $grid[$x][$len-1-$y];
        }
    }
    return $new;
}




// foreach over the lines and positions and apply three different regex
// when found replace the monster's pixels with Os

// count


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
