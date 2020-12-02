<?php

require 'password.php';

$count = 0;
foreach (file('in.txt') as $pw) {
    if ((new password($pw))->isValid()) {
        $count++;
    }
}

echo $count;

