<?php
/*
Disc #1 has 13 positions; at time=0, it is at position 10.
Disc #2 has 17 positions; at time=0, it is at position 15.
Disc #3 has 19 positions; at time=0, it is at position 17.
Disc #4 has 7 positions; at time=0, it is at position 1.
Disc #5 has 5 positions; at time=0, it is at position 0.
Disc #6 has 3 positions; at time=0, it is at position 1.
*/

/*
Disc #1 has 5 positions; at time=0, it is at position 4.
Disc #2 has 2 positions; at time=0, it is at position 1.
*/
$second = 0;
$i = 0;
while (true) {
    ++$i;
    if (0 !== (4 + 1 + $i) % 5) {
        continue;
    }

    if (0 !== (1 + 2 + $i) % 2) {
        continue;
    }

    die("turns: " . $i);
}


