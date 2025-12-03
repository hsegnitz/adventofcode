<?php

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;

foreach ($lines as $line) {
    $jolter = new Jolter($line);
    $sum += $jolter->getJoltage();
}

echo "\n\n", $sum, "\n";

class Jolter {
    private int $length;
    public function __construct(private readonly string $input)
    {
        $this->length = strlen($this->input);
    }

    public function getJoltage(): int
    {
        $posLargest = PHP_INT_MAX;
        $found = 0;
        for ($i = 9; $i >= 0; $i--) {
            if (($tempPosLargest = strpos($this->input, $i)) !== false && $tempPosLargest !== $this->length-1) {
                $posLargest = $tempPosLargest;
                $found = $i;
                break;
            }
        }

        return (int)$i . max(str_split(substr($this->input, $posLargest + 1)));
    }
}


