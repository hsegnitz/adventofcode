<?php

$in = file_get_contents('in.txt');

$cnt = count_chars($in);

#print_r($cnt);

echo $cnt[40] - $cnt[41];


