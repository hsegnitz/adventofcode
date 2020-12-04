<?php

require_once './passport.php';

$rawInput = file_get_contents('./demo.txt');
//$rawInput = file_get_contents('./in.txt');

$rawPassports = explode("\n\n", $rawInput);
$countValid = 0;
foreach ($rawPassports as $rawPassport) {
    $passport = new passport($rawPassport);
    if ($passport->isValidDay1()) {
        ++$countValid;
    }
}

echo $countValid, "\n";
