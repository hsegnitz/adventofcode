<?php

$input = file('in.txt');

function isNiceString($in)
{
    if (0 === preg_match('/([a-z]{2}).*\1/', $in)) {
        return false;
    }

    if (0 === preg_match('/([a-z]).\1/', $in)) {
        return false;
    }

    return true;
}

$countNice = 0;

foreach ($input as $in) {
    if (isNiceString($in)) {
        ++$countNice;
    }
}

echo $countNice;
