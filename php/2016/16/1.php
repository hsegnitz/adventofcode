<?php

$size = 272;

function dragon (string $in): string
{
    return $in . '0' . strtr(implode('', array_reverse(str_split($in))), "01", "10");
}

$pattern = '01111010110010011';
while (strlen($pattern) < $size) {
    $pattern = dragon($pattern);
}

echo $pattern;
