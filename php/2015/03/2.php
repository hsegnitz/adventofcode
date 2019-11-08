<?php

$input = file_get_contents('in.txt');

$seen = [];

$santaX = 0;
$santaY = 0;
$roboX = 0;
$roboY = 0;

function registerCoordinate($x, $y)
{
    $key = "{$x}x{$y}";
    if (!isset($GLOBALS['seen'][$key])) {
        $GLOBALS['seen'][$key] = 0;
    }
    ++$GLOBALS['seen'][$key];
}

registerCoordinate(0, 0);

foreach (str_split($input, 2) as $chars) {
    switch ($chars[0]) {
        case '^':
            --$santaY;
            break;
        case 'v':
            ++$santaY;
            break;
        case '<':
            --$santaX;
            break;
        case '>':
            ++$santaX;
            break;
        default:
            die('invalid direction ' . $char);
    }
    registerCoordinate($santaX, $santaY);

    switch ($chars[1]) {
        case '^':
            --$roboY;
            break;
        case 'v':
            ++$roboY;
            break;
        case '<':
            --$roboX;
            break;
        case '>':
            ++$roboX;
            break;
        default:
            die('invalid direction ' . $char);
    }
    registerCoordinate($roboX, $roboY);
}

echo count($seen);
