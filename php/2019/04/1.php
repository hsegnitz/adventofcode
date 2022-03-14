<?php

$startTime = microtime(true);

class PasswordValidator
{

    public function run(): void
    {
        $count1 = 0;
        $count2 = 0;
        for ($i = 367479; $i <= 893698; $i++) {
            if ($this->isValid1($i)) {
                ++$count1;
            }
            if ($this->isValid2($i)) {
                ++$count2;
            }
        }

        echo 'part 1: ', $count1, "\npart 2: ", $count2;
    }

    private function isValid1(int $input): bool
    {
        if (!preg_match('/^\d*(\d)(\1)\d*$/', (string)$input)) {
            return false;
        }

        return $this->isAscending($input);
    }

    public function isValid2(int $input): bool
    {
        if (!$this->isAscending($input)) {
            return false;
        }

        $in = preg_replace('/(\d)\1{2,}/', "x", $input);

        return preg_match('/^.*(\d)(\1).*$/', $in);
    }

    private function isAscending(string $input): bool
    {
        return $input[0] <= $input[1]
            && $input[1] <= $input[2]
            && $input[2] <= $input[3]
            && $input[3] <= $input[4]
            && $input[4] <= $input[5];
    }
}

(new PasswordValidator())->run();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
