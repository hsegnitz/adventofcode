<?php

$input = file('in.txt');

function isNiceString($in)
{
    $chars = count_chars($in);
    $vowelCount = $chars[ord('a')] + $chars[ord('e')] + $chars[ord('i')] + $chars[ord('o')] + $chars[ord('u')];
    if ($vowelCount <= 2) {
        return false;
    }

    if (0 === preg_match('/([a-z])\1/', $in)) {
        return false;
    }

    if (false !== strpos($in, 'ab') || false !== strpos($in, 'cd') || false !== strpos($in, 'pq') || false !== strpos($in, 'xy')) {
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
