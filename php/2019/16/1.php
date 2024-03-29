<?php

namespace Y2019\D16;

$startTime = microtime(true);

class Solver
{
    private string $small1 = "12345678";
    private string $small2 = "80871224585914546619083218645595";
    private string $small3 = "19617804207202209144916044189917";
    private string $small4 = "69317163492948606335995924319873";
    private string $input  = "59709511599794439805414014219880358445064269099345553494818286560304063399998657801629526113732466767578373307474609375929817361595469200826872565688108197109235040815426214109531925822745223338550232315662686923864318114370485155264844201080947518854684797571383091421294624331652208294087891792537136754322020911070917298783639755047408644387571604201164859259810557018398847239752708232169701196560341721916475238073458804201344527868552819678854931434638430059601039507016639454054034562680193879342212848230089775870308946301489595646123293699890239353150457214490749319019572887046296522891429720825181513685763060659768372996371503017206185697";

    public function __construct()
    {
        $out = $this->input;
        for ($i = 0; $i < 100; $i++) {
            $out = $this->calcPhase($out);
//            echo $out, "\n";
        }

        // part 1
        echo substr($out, 0, 8);

// part2
// so, this has to have a secret as we don't have roughly 25hours of CPU time to solve this the brute force way.
// * just doing it for the numbers after offset -> nope
// * last digit is always the same
// * second to last digit rotates in a 10 phase
// * the ones before even slower, but they repeat...
// * when there are blocks of repeating zeros in one line, the next line has whatever digit is in there repeated in the same place
// * to be precise repeated even once more!
// * when there are repeated ones, the digits decrease by 1 below the ones
// * same with 2s, decreasing by two
// * and actually, with modulo applied, it works for all digits  Oo
// * sooo.... newline[x] = newline[x-1] - oldline[x] or something
// * damnit, that only works for numbers near the end and we need the previous ones anyways...
// ... the end is alwoys the same ...
// that formula can go the other way round actually => newline[x] = newline[x+1] + oldline[x]   (and mod applied!!!)  !!


        // part 2
        $out2 = $this->longInput($this->input);
        echo $out2, "\n";
        $offset = (int)substr($out2, 0, 7);
        echo $offset, "\n";

        $remainder = substr($out2, $offset);
        echo $remainder, "\n";

        // make the hind part of the string into an array of ints to not go back and forth with a string
        $temp = str_split($remainder);

        for ($i = 0; $i < 100; $i++) {
            for ($pos = count($temp) - 2; $pos >= 0; $pos--) {
                $a = $temp[$pos + 1];
                $b = $temp[$pos];
                $newNumber = $a + $b;
                $temp[$pos] = abs($newNumber % 10);
            }
        }

        for ($i = 0; $i < 8; $i++) {
            echo $temp[$i];
        }
    }

    private function longInput(string $input): string
    {
        return str_repeat($input, 10000);
    }

    private function calcPhase(string $input): string
    {
        $out = '';
        for ($i = 0, $iMax = strlen($input); $i < $iMax; $i++) {
            $multiplicands = $this->getListOfMultiplicands($i+1, $iMax);
            $newNum = 0;
            for ($j = 0; $j < $iMax; $j++) {
                $newNum += $input[$j] * $multiplicands[$j];
            }
            $out .= abs($newNum % 10);
        }

        return $out;
    }

    private function getListOfMultiplicands(int $phase, int $length): array
    {
        $out = [];
        $elements = [0, 1, 0, -1];

        for ($i = 0; $i <= $length; $i += $phase) {
            $toAdd = $elements[($i/$phase) % count($elements)];
            for ($j = 0; $j < $phase; $j++) {
                $out[] = $toAdd;
            }
        }
        array_shift($out);
        return $out;
    }
}

new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
