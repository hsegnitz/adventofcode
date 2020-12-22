<?php

$startTime = microtime(true);

require __DIR__ . '/Tile.php';

$rawInput = trim(file_get_contents(__DIR__ . '/in.txt'));

$tiles = [];
foreach (explode("\n\n", $rawInput) as $rawTile) {
    $tile = new Tile($rawTile);
    $tiles[$tile->getId()] = $tile;
}

$edgeSize = sqrt(count($tiles));

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

/*
$debug = [];
foreach ($matchesPerTile as $tileK => $matchingTiles) {
    $debug[$tileK] = count($matchingTiles);
}

print_r(array_count_values($debug));
#die();
*/


$corners = [];
foreach ($matchesPerTile as $tileK => $matchingTiles) {
    if (count($matchingTiles) === 2) {
        $corners[$tileK] = $tiles[$tileK];
    }
}




#print_r($corners);

// pick any corner, make it 0, 0

$firstKey = array_key_first($corners);

$grid = [
    0 => [
        0 => clone $corners[$firstKey],
    ],
];

unset ($tiles[$firstKey]);


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


// assemble the grid by matching the rows

for ($y = 0; $y < $edgeSize; $y++) {
    for ($x = 0; $x < $edgeSize; $x++) {
        if ($x ===0 && $y === 0) {
            continue;
        }

        if ($x === 0) {
            $cur = $grid[$y-1][$x];
            foreach ($matchesPerTile[$cur->getId()] as $tile) {
                if (!isset($tiles[$tile->getId()])) {
                    continue; // piece already taken rotating them would destroy the grid!
                }

                $bottomEdge = $cur->getAppliedBottom();
                foreach ([false, true] as $flip) {
                    $tile->setFlipped($flip);
                    foreach (Tile::ORIENTATIONS as $orientation) {
                        $tile->setOrientation($orientation);
                        if ($bottomEdge === $tile->getAppliedTop()) {
                            $grid[$y][$x] = $tile;
                            unset($tiles[$tile->getId()]);
                            continue 4;
                        }
                    }
                }
            }
        }

        $cur = $grid[$y][$x-1];
        foreach ($matchesPerTile[$cur->getId()] as $tile) {
            if (!isset($tiles[$tile->getId()])) {
                continue; // pice already taken rotating them would destroy the grid!
            }

            $rightEdge = $cur->getAppliedRight();
            foreach ([false, true] as $flip) {
                $tile->setFlipped($flip);
                foreach (Tile::ORIENTATIONS as $orientation) {
                    $tile->setOrientation($orientation);
                    if ($rightEdge === $tile->getAppliedLeft()) {
/*                        if ($y > 0) {
                            $bottomEdge = $grid[$y-1][$x]->getAppliedBottom();
                            if ($bottomEdge !== $tile->getAppliedTop()) {
                                continue;
                            }
                        }*/
/*                        if (isset($grid[$y][$x])) {
                            throw new RuntimeException('FUCK');
                        }*/
                        $grid[$y][$x] = clone $tile;
                        unset($tiles[$tile->getId()]);
                    }
                }
            }
        }
    }
}


/*
//debug
foreach ($grid as $row) {
    foreach ($row as $tile) {
        echo $tile->getId(), " ";
    }
    echo "\n";
}
*/

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

// just for show!
$monster = <<<MONSTER
                  # 
#    ##    ##    ###
 #  #  #  #  #  #   
MONSTER;


foreach ([false, true] as $flip) {
    if ($flip) {
        $bigGrid = flip($bigGrid);
    }
    foreach ([0, 1, 2, 3] as $numRot) {   // the fourth iteration rotates back to original, so the first is already rotated, who cares, right?
        $bigGrid = rotateLeft($bigGrid);
        $mapAsString = '';
        foreach ($bigGrid as $row) {
            $mapAsString .= implode('', $row) . "\n";
        }
        $mapWithHighlights = huntMonsters($mapAsString);
        if ($mapWithHighlights !== $mapAsString) {
            break 2;
        }
    }
}

//debug
//echo $mapAsString, "\n";


// this is almost silly, but well, who doesn't love their regex!
function huntMonsters(string $map): string
{
    $depth = strpos($map, "\n") - 20;

    $replace = '\1O\2O\3OO\4OO\5OOO\6O\7O\8O\9O\10O\11O\12';

    for ($i = 0; $i < $depth; $i++) {
        $search = "/(.{{$i}}.{18})#(..*\n.{{$i}})#(....)##(....)##(....)###(.*\n.{{$i}}.)#(..)#(..)#(..)#(..)#(..)#(.)/";
        $count = 1;
        while ($count > 0) {
            $map = preg_replace($search, $replace, $map, -1, $count);
        }
    }

    return $map;
}

#echo $mapWithHighlights;

echo "\n";
$cnt = count_chars($mapWithHighlights, 1);

echo $cnt[ord('#')];




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
