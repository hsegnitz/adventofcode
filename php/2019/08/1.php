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

        echo ($this->countChars($candidate, "1") * $this->countChars($candidate, "2")), "\n\n";

        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $offset = ($y * $this->width) + $x;
                while ("2" === $input[$offset]) {
                    $offset += $step;
                }

                if ("1" === $input[$offset]) {
                    echo "X";
                } else {
                    echo " ";
                }
            }
            echo "\n";
        }
    }

    private function countChars(string $input, string $character): int {
        return count_chars($input)[ord($character)];
    }
}

$solver = new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
