<?php

namespace Year2023\Day13;

$start = microtime(true);

#$in = file_get_contents('example.txt');
$in = file_get_contents('input.txt');

$blocks = explode("\n\n", $in);

class Map {
    private array $map = [];

    private array $byCols = [];

    public function __construct(string $raw)
    {
        foreach (explode("\n", $raw) as $line) {
            $this->map[] = str_split($line);
        }

        for ($i = 0, $max = count($this->map[0]); $i < $max; $i++) {
            $this->byCols[] = array_column($this->map, $i);
        }
    }

    private function findFold(array $in): ?int
    {
        for ($i = 0, $max=count($in)-1; $i<$max; $i++) {
            if ($this->isFold($in, $i)) {
#                echo $i+1, "\n";
                return $i+1;
            }
        }
        return null;
    }

    private function isFold(array $in, int $lineNumber): bool
    {
        $a = $lineNumber;
        $b = $lineNumber+1;
        while (isset($in[$a], $in[$b])) {
            if ($in[$a] !== $in[$b]) {
                return false;
            }
            --$a;
            ++$b;
        }

        return true;
    }

    public function getScore(): int
    {
        if (null !== ($score = $this->findFold($this->map))) {
            return $score * 100;
        }

        if (null !== ($score = $this->findFold($this->byCols))) {
            return $score;
        }

        throw new \RuntimeException('it should reflect but does not? :(');
    }

}

$sum = 0;
foreach ($blocks as $block) {
    $map = new Map($block);
    $sum += $map->getScore();
}


echo "\n", $sum, "\n";


echo microtime(true) - $start;
echo "\n";

