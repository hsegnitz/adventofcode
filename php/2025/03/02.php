<?php

$start = microtime(true);

#$lines = file('example.txt', FILE_IGNORE_NEW_LINES);
$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;

foreach ($lines as $line) {
    $jolter = new Jolter($line);
    echo $line, ": ", ($joltage = $jolter->getJoltage()), "\n";
    $sum += $joltage;
}

echo "\n\n", $sum, "\n";

class Jolter
{
    private const TARGET_LENGTH = 12;
    private int $length;

    public function __construct(private readonly string $input)
    {
        $this->length = strlen($this->input);
    }

    public function getJoltage(): int
    {
        $joltage = '';
        $lastPos = 0;

        while (strlen($joltage) < self::TARGET_LENGTH) {
            for ($i = 9; $i > 0; $i--) {
                if (($pos = strpos($this->input, $i, $lastPos)) !== false && $pos < ($this->length - (self::TARGET_LENGTH - strlen($joltage)) +1)) {
                    $lastPos = $pos+1;
                    $joltage .= $i;
                    break;
                }
            }
        }

        return (int)$joltage;
    }
}

