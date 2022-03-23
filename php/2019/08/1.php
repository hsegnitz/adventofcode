<?php

$startTime = microtime(true);

class Solver {

    private int $width  = 25;
    private int $height =  6;

    public function __construct()
    {
        $input = file_get_contents('in.txt');

        $step = $this->width * $this->height;
        $numberOfZeros = PHP_INT_MAX;

        $candidate = "";
        for ($i = 0, $iMax = strlen($input); $i < $iMax; $i += $step) {
            $substr = substr($input, $i, $step);
            $zeroCount = $this->countChars($substr, "0");
            if ($zeroCount < $numberOfZeros) {
                $numberOfZeros = $zeroCount;
                $candidate = $substr;
            }
        }

        echo ($this->countChars($candidate, "1") * $this->countChars($candidate, "2"));
    }

    private function countChars(string $input, string $character): int {
        return count_chars($input)[ord($character)];
    }
}

$solver = new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
