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

$pattern = substr($pattern, 0, $size);
#echo $pattern;

function checksum($in): string
{
    $ret = '';
    foreach (str_split($in, 2) as $item) {
        switch ($item) {
            case "00":
            case "11":
                $ret .= '1';
                break;
            case "01":
            case "10":
                $ret .= '0';
                break;
        }
    }
    return $ret;
}

$checksum = $pattern;
while (0 === strlen($checksum) % 2) {
    $checksum = checksum($checksum);
}

echo $checksum, "\n";

