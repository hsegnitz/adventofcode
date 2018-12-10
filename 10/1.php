<?php

$lines = file('in.txt');
$points = [];

class point
{
    const PATTERN = '/position=<\s*(-?\d+),\s*(-?\d+)> velocity=<\s*(-?\d+),\s*(-?\d+)>/';

    /** @var int */
    private $posx;

    /** @var int */
    private $posy;

    /** @var int */
    private $vx;

    /** @var int */
    private $vy;

    public function __construct($line)
    {
        $out = [];
        if (!preg_match(self::PATTERN, $line, $out)) {
            throw new RuntimeException('could not parse line');
        }
        $this->posx = $out[1];
        $this->posy = $out[2];
        $this->vx = $out[3];
        $this->vy = $out[4];
    }

    public function positionAt($seconds)
    {
        return [
            'x' => $this->posx + ($seconds * $this->vx),
            'y' => $this->posy + ($seconds * $this->vy),
        ];
    }
}

$points = [];
foreach ($lines as $line) {
    $points[] = new point($line);
}

// find out when area covering all points is smallest-ish
// we found out that the points are in positive area between 100 and 300 -- let's make the image 0,300

$smallestAreaAtSecond = 0;
$currentlySmallestArea = PHP_INT_MAX;
for ($second = 0; $second < 11000; $second++) {
    $allx = [];
    $ally = [];

    /** @var point $point */
    foreach ($points as $point) {
        list('x' => $allx[], 'y' => $ally[]) = $point->positionAt($second);
    }

    $sizeX = max($allx) - min($ally);
    $sizeY = max($ally) - min($ally);

    $newArea = $sizeX * $sizeY;

    if ($newArea < $currentlySmallestArea) {
        $currentlySmallestArea = $newArea;
        $smallestAreaAtSecond = $second;
    }

    // echo '[', $second, '] :: [', $smallestAreaAtSecond, '] :: [', $currentlySmallestArea, '] :: [', $newArea, "]\n";
}

echo 'smallest area in second ', $smallestAreaAtSecond;

$fromSecond = $smallestAreaAtSecond - 10;
$toSecond = $smallestAreaAtSecond   + 10;
for ($second = $fromSecond; $second < $toSecond; $second++) {
    $image = imagecreate(300, 300);
    $color = imagecolorallocate($image, 0, 0, 0);
    imagefill($image, 5, 5, $color);

    $color = imagecolorallocate($image, 255, 255, 255);

    /** @var point $point */
    foreach ($points as $point) {
        list('x' => $x, 'y' => $y) = $point->positionAt($second);
        imagesetpixel($image, $x, $y, $color);
    }

    imagepng($image, __DIR__ . '/out-' . $second . '.png');
}



