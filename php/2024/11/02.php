<?php

use common\ArrayKeyCache;

$start = microtime(true);

require_once '../../common/ArrayKeyCache.php';

#$input = file_get_contents('example.txt');
$input = file_get_contents('input.txt');

$rawStones = explode(' ', $input);
$stones = [];
foreach ($rawStones as $rawStone) {
    $stones[] = (int)$rawStone;
}

// situation: we don't have multiple TB of RAM and infinite time.
// strategy: we need to somehow sum up the count of stones without storing them all
// that means we need to cache results, as we're only interested in the count, let's find out after how many blinks a certain input number splits and into what
// better: let's store into how many they split with x blinks left

class blinkCached {
    private ArrayKeyCache $store;

    public function __construct() {
        $this->store = new ArrayKeyCache('x');
    }

    public function blink(int $stone, int $blinksLeft) : int
    {
        $key = [$stone, $blinksLeft];
        if ($this->store->has($key)) {
            return $this->store->retrieve($key);
        }

        $result = $this->doTheBlink($stone, $blinksLeft);
        $this->store->store($key, $result);
        return $result;
    }

    private function doTheBlink(int $stone, int $blinksLeft): int
    {
        if ($blinksLeft <= 0) {
            return 1;
        }

        if ($stone === 0) {
            return $this->blink(1, $blinksLeft - 1);
        }

        if (strlen($stone) % 2 === 1) {
            return $this->blink($stone * 2024, $blinksLeft - 1);
        }

        [$left, $right] = str_split((string)$stone, strlen((string)$stone) / 2);
        return $this->blink($left, $blinksLeft - 1) + $this->blink($right, $blinksLeft - 1);
    }
}

$bc = new blinkCached();

$sum = 0;
foreach ($stones as $stone) {
    $sum += $bc->blink($stone, 75);
}

echo $sum, "\n";

echo microtime(true) - $start;
echo "\n";
