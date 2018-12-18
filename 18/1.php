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
    $concat = [];
    foreach ($map as $row) {
        $concat[] = implode('', $row);
    }
    $concat = implode('', $concat);
    
    $result = count_chars($concat, 1);

    print_r($result);

    $trees       = $result[ord('|')];
    $lumberyards = $result[ord('#')];

    echo $trees, ' ', $lumberyards, ' ', $trees*$lumberyards, "\n";
}


$map = [];
foreach (file('in.txt') as $numRow => $row) {
    $map[$numRow] = [];
    foreach (str_split(trim($row), 1) as $col => $char) {
        $map[$numRow][$col] = $char;
    }
}

output($map);
for ($i = 1; $i <= 10; $i++) {
    echo 'round ', $i, "\n";
    $map = tick($map);
    output($map);
}

countTiles($map);

