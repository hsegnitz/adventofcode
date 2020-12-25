<?php

$startTime = microtime(true);

/*   */
$pkCard = 14788856;
$pkDoor = 19316454;
/*  */

$mod = 20201227;

/* demo
$pkCard = 5764801;
$pkDoor = 17807724;
*/

$subjectNumberCard = 1;

$loopCountCard = 0;
while ($subjectNumberCard !== $pkCard) {
    $subjectNumberCard = (7 * $subjectNumberCard) % $mod;
    ++$loopCountCard;
}
echo $loopCountCard, "\n";

$subjectNumberDoor = 1;
for ($j = 0; $j < $loopCountCard; $j++) {
    $subjectNumberDoor = ($pkDoor * $subjectNumberDoor) % $mod;
}
 echo $subjectNumberDoor, "\n";




echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
