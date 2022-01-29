<?php

$step       =        4;
$end        =       99;
$targetDay2 = 19690720;

$small0 = [1,9,10,3,2,3,11,0,99,30,40,50];
$small1 = [1,0,0,0,99];
$small2 = [2,3,0,3,99];
$small3 = [2,4,4,5,99,0];
$small4 = [1,1,1,4,99,5,6,0,99];
$input  = [1,0,0,3,1,1,2,3,1,3,4,3,1,5,0,3,2,6,1,19,1,19,5,23,2,9,23,27,1,5,27,31,1,5,31,35,1,35,13,39,1,39,9,43,1,5,43,47,1,47,6,51,1,51,13,55,1,55,9,59,1,59,13,63,2,63,13,67,1,67,10,71,1,71,6,75,2,10,75,79,2,10,79,83,1,5,83,87,2,6,87,91,1,91,6,95,1,95,13,99,2,99,13,103,1,103,9,107,1,10,107,111,2,111,13,115,1,10,115,119,1,10,119,123,2,13,123,127,2,6,127,131,1,13,131,135,1,135,2,139,1,139,6,0,99,2,0,14,0];

echo (new Computer())->run($small0), "\n";
echo (new Computer())->run($small1), "\n";
echo (new Computer())->run($small2), "\n";
echo (new Computer())->run($small3), "\n";
echo (new Computer())->run($small4), "\n";

$program = $input;
$program[1] = 12;
$program[2] =  2;
echo (new Computer())->run($program), "\n";


class Computer {

    private const step =  4;
    private const end  = 99;

    public function run(array $program): int
    {
        $pointer = 0;
        while (true) {
            if ($program[$pointer] === self::end) {
                return $program[0];
            }
            $a = $program[$pointer + 1];
            $b = $program[$pointer + 2];
            $c = $program[$pointer + 3];
            if ($program[$pointer] === 1) {
                $program[$c] = $program[$a] + $program[$b];
            } elseif ($program[$pointer] === 2) {
                $program[$c] = $program[$a] * $program[$b];
            }
            $pointer += self::step;
        }
    }
}
