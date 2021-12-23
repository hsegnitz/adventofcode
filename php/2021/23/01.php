<?php

$startTime = microtime(true);

$input = '...........BACDBCDA';
#$input = '...........DBCADABC';

const TARGET_STATE = '...........AABBCCDD';

const COSTS = [
    'A' =>    1,
    'B' =>   10,
    'C' =>  100,
    'D' => 1000,
];

const ENTRANCES = [2, 4, 6, 8];
const ROOMTOPS = [
    'A' => 11,
    'B' => 13,
    'C' => 15,
    'D' => 16,
];

const TARGETPOSITIONS = [
    'A' => [11, 12],
    'B' => [13, 14],
    'C' => [15, 16],
    'D' => [16, 18],
];

function switchPositions(string $map, int $a, int $b): string    //a.k.a. do the move
{
    $ret = $map;
    $ret[$a] = $map[$b];
    $ret[$b] = $map[$a];
    return $ret;
}

function legalMovesFromState(string $state): Generator
{
    // move 'em down should they be in their room, on the top position and the bottom is empty
    foreach (ROOMTOPS as $type => $pos) {
        if ($state[$pos] === $type && $state[$pos+1] === '.') {
            yield [switchPositions($state, $pos, $pos+1) => COSTS[$type]];
        }
    }

    // move 'em up should they not be in their room, and the top position is empty
    foreach (ROOMTOPS as $type => $pos) {
        if ($state[$pos+1] !== $type && $state[$pos+1] !== '.' && $state[$pos] === '.') {
            yield [switchPositions($state, $pos, $pos+1) => COSTS[$state[$pos+1]]];
        }
    }


}











echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

