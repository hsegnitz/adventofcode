<?php

$startTime = microtime(true);

#$input = '...........A..BBBBBCCCCDDDD';
$input = "...........BDDACCBDBBACDACA";
#$input = '...........DDDBCCBADBAABACC';

const TARGET_STATE = '...........AAAABBBBCCCCDDDD';

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
    'B' => 15,
    'C' => 19,
    'D' => 23,
];

const TARGETPOSITIONS = [
    'A' => [11, 12, 13, 14],
    'B' => [15, 16, 17, 18],
    'C' => [19, 20, 21, 22],
    'D' => [23, 24, 25, 26],
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
    // move 'em down should they be in their room, on the top position and the lower positions are empty
    foreach (ROOMTOPS as $type => $pos) {
        if ($state[$pos] !== $type) {
            continue;
        }

        if (substr($state, $pos + 1, 3) === ".{$type}{$type}") {
            yield switchPositions($state, $pos, $pos + 1) => COSTS[$type];
            continue;
        }
        if (substr($state, $pos + 1, 3) === "..{$type}") {
            yield switchPositions($state, $pos, $pos + 2) => COSTS[$type] * 2;
            continue;
        }
        if (substr($state, $pos + 1, 3) === "...") {
            yield switchPositions($state, $pos, $pos + 3) => COSTS[$type] * 3;
        }
    }

    // move 'em up should they not be in their room, and the top position is empty
    foreach (ROOMTOPS as $type => $pos) {
        if ($state[$pos] !== '.') {
            continue;
        }

        $check = substr($state, $pos, 2);
        $pattern = "/^\.[^{$type}.]$/";
        if (preg_match($pattern, $check)) {
            yield switchPositions($state, $pos, $pos+1) => COSTS[$state[$pos+1]];
            continue;
        }

        $check = substr($state, $pos, 3);
        $pattern = "/^\.\.[^{$type}.]$/";
        if (preg_match($pattern, $check)) {
            yield switchPositions($state, $pos, $pos+2) => COSTS[$state[$pos+2]] * 2;
            continue;
        }

        $pattern = "/^\.\.\.[^{$type}.]$/";
        $check = substr($state, $pos, 4);
        if (preg_match($pattern, $check)) {
            yield switchPositions($state, $pos, $pos+3) => COSTS[$state[$pos+3]] * 3;
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
        for ($j = 1; $j <= 3; $j++) {
            if ($state[$targetTile + $j] !== '.' && $state[$targetTile + $j] !== $currentCritter) { // any bottom part in target room occupied by different race
                continue 2;
            }
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
        // making sure the things stay in their room when they are already in their target room and do not block something.
        $roomContent = substr($state, $position+1, 3);
        if ($critterType === $currentCritter && (preg_match('/^[.' . $currentCritter . ']{3}$/', $roomContent))) {
            continue;
        }

        // now we go left and right, skipping the roomtops and aborting the mission should we encounter an
        // occupied tile

        $entrance = ENTRANCES[$critterType];
        //left
        for ($pos = $entrance; $pos >= 0; $pos--) {
            if ($state[$pos] !== '.') {
                break;
            }
            if (in_array($pos, ENTRANCES)) {
                continue;
            }
            yield switchPositions($state, $position, $pos) => (COSTS[$currentCritter] * ($entrance - $pos + 1));
        }

        //right
        for ($pos = $entrance; $pos < 11; $pos++) {
            if ($state[$pos] !== '.') {
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
    echo "###{$state[11]}#{$state[15]}#{$state[19]}#{$state[23]}###\n";
    echo "  #{$state[12]}#{$state[16]}#{$state[20]}#{$state[24]}#\n";
    echo "  #{$state[13]}#{$state[17]}#{$state[21]}#{$state[25]}#\n";
    echo "  #{$state[14]}#{$state[18]}#{$state[22]}#{$state[26]}#\n";
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

