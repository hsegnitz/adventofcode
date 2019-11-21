<?php

$input = file_get_contents('in.txt');

$seen = [];

$currentX = 0;
$currentY = 0;

function registerCoordinate($x, $y)
{
    $key = "{$x}x{$y}";
    if (!isset($GLOBALS['seen'][$key])) {
        $GLOBALS['seen'][$key] = 0;
    }
    ++$GLOBALS['seen'][$key];
}

registerCoordinate(0, 0);

foreach (str_split($input) as $char) {
    switch ($char) {
        case '^':
            --$currentY;
            break;
        case 'v':
            ++$currentY;
            break;
        case '<':
            --$currentX;
            break;
        case '>':
            ++$currentX;
            break;
        default:
            die('invalid direction ' . $char);
    }
    registerCoordinate($currentX, $currentY);
}


echo count($seen);
