<?php

$startTime = microtime(true);

class Elf
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

/** @var Elf[] $list * /
$list = [];
//for ($i = 1; $i <= 3018458; $i++) {
for ($i = 1; $i <= 5; $i++) {
    $list[] = new Elf($i);
}
/*    */

#$list = range(1, 5);
$list = range(1, 3018458);


$current = 0;
while (count($list) > 1) {
    $count = count($list);
    $opposite = $current + floor($count / 2);
    $opposite %= $count;
    $current++;
    $current %= $count;
    $list = array_values($list);
    if ($count % 100 === 0) {
        echo $count, ": ", (microtime(true) - $startTime), "\n";
    }
    unset ($list[$opposite]);
}

print_r($list);


echo "total time: ", (microtime(true) - $startTime), "\n";
