<?php

require_once './passport.php';

//$rawInput = file_get_contents('./demo.txt');
//$rawInput = file_get_contents('./demo2.txt');
$rawInput = file_get_contents('./in.txt');

$rawPassports = explode("\n\n", $rawInput);
$countValid1 = $countValid2 = 0;
foreach ($rawPassports as $rawPassport) {
    $passport = new passport($rawPassport);
    if ($passport->isValid1()) {
        ++$countValid1;
        if ($passport->isValid2()) {
            ++$countValid2;
        }
    }
}

echo "valid 1: ", $countValid1, "\n";
echo "valid 2: ", $countValid2, "\n";
