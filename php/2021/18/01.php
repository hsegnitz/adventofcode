<?php

$startTime = microtime(true);

$input = file('./example0.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example1.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example2.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example3.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example4.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

class SnailfishNumber {

    public function __construct(private $x, private $y) {
    }

    public function __toString(): string
    {
        return '[' . $this->x . ',' . $this->y . ']';
    }

    public static function fromString(string $line): SnailfishNumber
    {
        // find the comma at bracket count 1
        $bracketCount = 0;
        for ($i = 1, $iMax = strlen($line)-1; $i < $iMax; $i++) {
            if ($line[$i] === "[") {
                ++$bracketCount;
                continue;
            }
            if ($line[$i] === "]") {
                --$bracketCount;
                continue;
            }
            if ($line[$i] === "," && $bracketCount === 0) {
                $left  = substr($line, 1, $i-1);
                $right = substr($line, $i+1, -1);
                if (!is_numeric($left)) {
                    $left = self::fromString($left);
                }
                if (!is_numeric($right)) {
                    $right = self::fromString($right);
                }
                return new self($left, $right);
            }
        }
        throw new RuntimeException('This should not happen.');
    }
}


$originalNumbers = [];
foreach ($input as $line) {
    $originalNumbers[] = SnailfishNumber::fromString($line);
}

foreach ($originalNumbers as $on) {
    echo $on, "\n";
}



echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

