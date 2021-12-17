<?php

$startTime = microtime(true);

# target area: x=20..30, y=-10..-5
/*
$targetMinX = 20;
$targetMaxX = 30;

$targetMinY = -10;
$targetMaxY = -5;
*/

# target area: x=169..206, y=-108..-68
/* */
$targetMinX = 169;
$targetMaxX = 206;

$targetMinY = -108;
$targetMaxY = -68;
/*   */

/**
 * @param int $velocityX
 * @param int $velocityY
 * @param int $targetMinX
 * @param int $targetMaxX
 * @param int $targetMinY
 * @param int $targetMaxY
 * @return int|null  maximum height if it's a hit null if miss.
 */
function shoot(int $velocityX, int $velocityY, int $targetMinX, int $targetMaxX, int $targetMinY, int $targetMaxY): ?int
{
    $maxHeight = 0;
    $posX = $posY = 0;
    while ($posX < $targetMaxX && $posY > $targetMinY) {
        $posX += $velocityX;
        $posY += $velocityY--;
        if ($velocityX > 0) {
            $velocityX--;
        }
        $maxHeight = max($maxHeight, $posY);

        if ($posX <= $targetMaxX && $posX >= $targetMinX && $posY <= $targetMaxY && $posY >= $targetMinY) {
            return $maxHeight;
        }
    }
    return null;
}





$curX = 0;
$curY = 0;

$hittingVelocities = [];

for ($velocityX = 1; $velocityX <= $targetMaxX; $velocityX++) {
    for ($velocityY = $targetMinY; $velocityY <= 400; $velocityY++) {   // 200 is a guess ;)
        if (null !== ($maxHeight = shoot($velocityX, $velocityY, $targetMinX, $targetMaxX, $targetMinY, $targetMaxY))) {
            $hittingVelocities["{$velocityX},{$velocityY}"] = $maxHeight;
        }
    }
}

echo max($hittingVelocities), '  ', count($hittingVelocities);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

