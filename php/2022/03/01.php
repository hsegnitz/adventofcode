<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

class Rucksack {
    private static array $priorities = [];
    private array $firstCompartment;
    private array $secondCompartment;

    public function __construct(private string $rawContent) {
        $this->firstCompartment  = str_split(substr($rawContent, 0, strlen($rawContent)/2));
        $this->secondCompartment = str_split(substr($rawContent, strlen($rawContent)/2));
    }

    private function getSharedItem(): string {
        $sharedItems = array_intersect(
            array_unique($this->firstCompartment),
            array_unique($this->secondCompartment)
        );

        if (count($sharedItems) !== 1) {
            throw new RuntimeException('something went wrong ' . print_r($sharedItems, true));
        }

        return array_values($sharedItems)[0];
    }

    public function getPriority(): int {
        return self::computePriority($this->getSharedItem());
    }

    private static function computePriority(string $character): int {
        if (self::$priorities === []) {
            $prios = array_merge(
                [0 => 'you will never find me!'],
                range('a', 'z'),
                range('A', 'Z')
            );
            self::$priorities = array_flip($prios);
        }

        return self::$priorities[$character];
    }
}

$scores = [];
foreach ($input as $line) {
    $scores[] = (new Rucksack($line))->getPriority();
}

echo 'Part 1: ', array_sum($scores);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

