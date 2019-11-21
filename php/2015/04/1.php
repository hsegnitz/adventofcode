<?php

$i = 0;
$input = 'bgvyzdsv';

while (0 !== strpos(md5($input . $i++), '00000')) {
    if ($i % 1000 === 0) {
        echo $i, "\n";
    }
}

echo $i - 1;