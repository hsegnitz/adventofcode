<?php

$startTime = microtime(true);

#$input = '...........BACDBCDA';
#$input = '..........A.ABBCCDD';
$input = '...........DBCADABC';

const TARGET_STATE = '...........AABBCCDD';

const COSTS = [
    'A' =>    1,
    'B' =>   10,
    'C' =>  100,
    'D' => 1000,
];

const ENTRANCES = [
    'A' => 2,
    'B' => 4,
    'C' => 6,
    'D' => 8,
];

// "the floor is lava" tiles
const ROOMTOPS = [
    'A' => 11,
    'B' => 13,
    'C' => 15,
    'D' => 17,
];

const TARGETPOSITIONS = [
    'A' => [11, 12],
    'B' => [13, 14],
    'C' => [15, 16],
    'D' => [17, 18],
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
            yield switchPositions($state, $pos, $pos+1) => COSTS[$type];
        }
    }

    // move 'em up should they not be in their room, and the top position is empty
    foreach (ROOMTOPS as $type => $pos) {
        if ($state[$pos+1] !== $type && $state[$pos+1] !== '.' && $state[$pos] === '.') {
            yield switchPositions($state, $pos, $pos+1) => COSTS[$state[$pos+1]];
        }
    }

    // go over things in the hallway and move them to the rooms -- only if the way is free.
    for ($i = 0; $i < 11; $i++) {
        if ($state[$i] === '.') {  // empty tiles we can ignore
            continue;
        }

        $currentCritter = $state[$i];
        $targetTile = ROOMTOPS[$currentCritter];
        if ($state[$targetTile] !== '.') {  // topmost tile in target room occupied -- can't move
            continue;
        }
        if ($state[$targetTile + 1] !== '.' && $state[$targetTile + 1] !== $currentCritter ) { // bottom part in target room occupied by different race
            continue;
        }

        $entrance = ENTRANCES[$currentCritter];
        if ($entrance > $i) {
            $checkAgainst = str_pad('.', ($entrance - $i), '.');
            if (substr($state, $i+1, $entrance - $i) === $checkAgainst) {
                yield switchPositions($state, $i, $targetTile) => (COSTS[$currentCritter] * ($entrance - $i + 1));
            }
        } elseif ($entrance < $i) {
            $checkAgainst = str_pad('.', ($i - $entrance), '.');
            $actual = substr($state, $entrance, $i - $entrance);
            if ($actual === $checkAgainst) {
                yield switchPositions($state, $i, $targetTile) => (COSTS[$currentCritter] * ($i - $entrance + 1));
            }
        }

    }

    // find all possible places to move into from the top of the room - only if top of room is occupied
    // and critter is not
    foreach (ROOMTOPS as $critterType => $position) {
        if ($state[$position] === '.') {  // empty tiles we can ignore
            continue;
        }

        $currentCritter = $state[$position];
        $tileContentBelow = $state[$position+1];
        // making sure the things stay in their room when they are already in their target room and do not block something.
        if ($critterType === $currentCritter && ($tileContentBelow === '.' || $tileContentBelow === $critterType)) {
            continue;
        }

        // now we go left and right, skipping the roomtops and aborting the mission should we encounter an
        // occupied tile

        $entrance = ENTRANCES[$critterType];
        //left
        for ($pos = $entrance; $pos >= 0; $pos--) {
            if ($state[$pos] !== '.') {  // topmost tile in target room occupied -- can't move
                break;
            }
            if (in_array($pos, ENTRANCES)) {
                continue;
            }
            yield switchPositions($state, $position, $pos) => (COSTS[$currentCritter] * ($entrance - $pos + 1));
        }

        //right
        for ($pos = $entrance; $pos < 11; $pos++) {
            if ($state[$pos] !== '.') {  // topmost tile in target room occupied -- can't move
                break;
            }
            if (in_array($pos, ENTRANCES)) {
                continue;
            }
            yield switchPositions($state, $position, $pos) => (COSTS[$currentCritter] * ($pos - $entrance + 1));
        }
    }
}

function out(string $state, int $cost): void
{
    echo 'Cost: ', $cost, "\n";
    echo "#############\n";
    echo "#", substr($state, 0, 11), "#\n";
    echo "###{$state[11]}#{$state[13]}#{$state[15]}#{$state[17]}###\n";
    echo "  #{$state[12]}#{$state[14]}#{$state[16]}#{$state[18]}#\n";
    echo "  #########\n\n";
}

// list of shortest ways to achieve a state;
$allStates = [
    $input => 0,
];

$stack = [$input];

while (count($stack)) {
    $currentState = array_shift($stack);
    $cost = $allStates[$currentState];
    foreach (legalMovesFromState($currentState) as $nextMove => $addedCost) {
        $totalCost = $cost + (int)$addedCost;
        if (isset($allStates[$nextMove]) && $allStates[$nextMove] <= $totalCost) {
            continue;
        }
        $allStates[$nextMove] = $totalCost;
        $stack[] = $nextMove;
    }
    #echo count($stack), "\n";
}

echo $allStates[TARGET_STATE];


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

