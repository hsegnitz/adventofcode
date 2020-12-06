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
    if (0 !== (10 + 1 + $i) % 13) {
        continue;
    }

    if (0 !== (15 + 2 + $i) % 17) {
        continue;
    }

    if (0 !== (17 + 3 + $i) % 19) {
        continue;
    }

    if (0 !== (1 + 4 + $i) % 7) {
        continue;
    }

    if (0 !== (0 + 5 + $i) % 5) {
        continue;
    }

    if (0 !== (1 + 6 + $i) % 3) {
        continue;
    }

    if (0 !== (0 + 7 + $i) % 11) {
        continue;
    }

    die("turns: " . $i . "\n");
}


