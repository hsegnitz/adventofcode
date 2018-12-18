<?php

function output($map)
{
    foreach ($map as $row) {
        echo implode('', $row), "\n";
    }
    echo "\n";
}


function tick($map)
{
    $newMap = [];
    foreach ($map as $numRow => $row) {
        foreach ($row as $numCol => $field) {
            $newMap[$numRow][$numCol] = evaluate($numCol, $numRow, $map);
        }
    }

    return $newMap;
}

function evaluate($numCol, $numRow, $map)
{
    if ('.' === $map[$numRow][$numCol]) {
        $count = 0;
        for ($x = $numCol-1; $x <= $numCol+1; $x++) {
            for ($y = $numRow-1; $y <= $numRow+1; $y++) {
                if (isset($map[$y][$x]) && '|' === $map[$y][$x]) {
                    if (++$count >= 3) {
                        return '|';
                    }
                }
            }
        }
        return '.';
    }

    if ('|' === $map[$numRow][$numCol]) {
        $count = 0;
        for ($x = $numCol-1; $x <= $numCol+1; $x++) {
            for ($y = $numRow-1; $y <= $numRow+1; $y++) {
                if (isset($map[$y][$x]) && '#' === $map[$y][$x]) {
                    if (++$count >= 3) {
                        return '#';
                    }
                }
            }
        }
        return '|';
    }

    if ('#' === $map[$numRow][$numCol]) {
        $foundLumberyard = false;
        $foundTrees = false;
        for ($x = $numCol-1; $x <= $numCol+1; $x++) {
            for ($y = $numRow-1; $y <= $numRow+1; $y++) {
                if ($x === $numCol && $y === $numRow) {
                    continue;
                }
                if (isset($map[$y][$x])) {
                    if ('#' === $map[$y][$x]) {
                        $foundLumberyard = true;
                    } elseif ('|' === $map[$y][$x]) {
                        $foundTrees = true;
                    }
                }
                if ($foundLumberyard && $foundTrees) {
                    return '#';
                }
            }
        }
        return '.';
    }

    throw new InvalidArgumentException($map[$numRow][$numCol] . ' should not exist');
}

function countTiles($map)
{
    $concat = hashMap($map);
    
    $result = count_chars($concat, 1);

    $trees       = $result[ord('|')];
    $lumberyards = $result[ord('#')];

    return $trees . ' ' . $lumberyards . ' ' . $trees*$lumberyards;
}

function hashMap($map)
{
    $concat = [];
    foreach ($map as $row) {
        $concat[] = implode('', $row);
    }
    return implode('', $concat);
}


$map = [];
foreach (file('in.txt') as $numRow => $row) {
    $map[$numRow] = [];
    foreach (str_split(trim($row), 1) as $col => $char) {
        $map[$numRow][$col] = $char;
    }
}

output($map);
$registry = [];
for ($i = 1; $i <= 1000000000; $i++) {
    $map = tick($map);
    $hash = hashMap($map);
    if (isset($registry[$hash])) {
        echo "previous round: ", $registry[$hash], " now: ", $i, " --- ", countTiles($map), "\n";
        $lastRounds = (1000000000 - $i) % 28;
        for ($j = 1; $j <= $lastRounds; $j++) {
            $map = tick($map);
        }
        break;
    }
    $registry[$hash] = $i;
}

echo countTiles($map);

