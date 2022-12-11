<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$rawMonkeys = explode("\n\n", $input);

class Monkey {
    private int $mulBy = 1;
    private int $add = 0;
    private bool $square = false;
    private array $items = [];
    private int $test;
    private Monkey $trueMonkey;
    private Monkey $falseMonkey;
    private int $inspections = 0;

    public function init(string $rawMonkey, array $allMonkeys): void {
        $rows = explode("\n", $rawMonkey);
        foreach (explode(', ', explode(': ', $rows[1])[1]) as $item) {
            $this->items[] = (int)$item;
        }

        if (substr_count($rows[2], 'old') === 2) {
            $this->square = true;
        } elseif (str_contains($rows[2], '*')) {
            $this->mulBy = (int)explode(' ', $rows[2])[7];
        } elseif (str_contains($rows[2], '+')) {
            $this->add = (int)explode(' ', $rows[2])[7];
        } else {
            throw new RuntimeException('weird operation row: ' . $rows[2]);
        }

        $this->test = (int)explode(' ', $rows[3])[5];
        $this->trueMonkey = $allMonkeys[(int)explode(' ', $rows[4])[9]];
        $this->falseMonkey = $allMonkeys[(int)explode(' ', $rows[5])[9]];
    }

    public function receiveItem(int $item): void
    {
        $this->items[] = $item;
    }

    public function getInspections(): int {
        return $this->inspections;
    }

    public function getItems(): array {
        return $this->items;
    }

    public function turn(): void
    {
        foreach ($this->items as $item) {
            $this->inspections++;
            if ($this->square) {
                $item *= $item;
            } else {
                $item += $this->add;
                $item *= $this->mulBy;
            }
            $item = (int)floor($item / 3);
            if ($item % $this->test === 0) {
                $this->trueMonkey->receiveItem($item);
            } else {
                $this->falseMonkey->receiveItem($item);
            }
        }
        $this->items = [];
    }
}

$allMonkeys = [];
foreach ($rawMonkeys as $num => $rawMonkey) {
    $allMonkeys[$num] = new Monkey();
}

foreach ($rawMonkeys as $num => $rawMonkey) {
    $allMonkeys[$num]->init($rawMonkey, $allMonkeys);
}

for ($i = 0; $i < 20; $i++) {
    foreach ($allMonkeys as $monkey) {
        $monkey->turn();
    }
    echo "Turn {$i}\n";
    debug($allMonkeys);
}

$inspections = [];
foreach ($allMonkeys as $num => $monkey) {
    $inspections[$num] = $monkey->getInspections();
}

/**
 * @param Monkey[] $allMonkeys
 * @return void
 */
function debug(array $allMonkeys): void {
    foreach ($allMonkeys as $num => $monkey) {
        echo 'Monkey ', $num, ': (', $monkey->getInspections(), ') ', implode(', ', $monkey->getItems()), "\n";
    }
    echo "\n";
}



rsort($inspections);

echo "Part 1: ", ($inspections[0] * $inspections[1]);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

