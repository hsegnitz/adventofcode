<?php

$startTime = microtime(true);

class Elf
{
    private int $presents = 1;

    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function stealFrom(Elf $victim): void
    {
        $this->presents += $victim->getPresents();
    }

    public function getPresents(): int
    {
        return $this->presents;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
/*
$list = new SplDoublyLinkedList();
for ($i = 1; $i <= 5; $i++) {
    $list->push(new Elf($i));
}

while ($list->count() > 1) {
    $list->rewind();
    while ($list->valid()) {
        /** @var Elf $current * /
        $current = $list->current();
        $list->next();
        /** @var Elf $nextElf * /
        $nextElf = $list->current();
        $nextKey = $list->key();
        $current->stealFrom($nextElf);
        $list->next();
        $list->offsetUnset($nextKey);
    }
}
*/

/** @var Elf[] $list */
$list = [];
for ($i = 1; $i <= 3018458; $i++) {
    $list[] = new Elf($i);
}

#print_r($list);

while (count($list) > 1) {
    $newList = [];
    for ($i = 0, $iMax = count($list); $i < $iMax; $i += 2) {
        if (!isset($list[$i+1])) {
            array_unshift($newList, $list[$i]);
            continue;
        }
        $list[$i]->stealFrom($list[$i+1]);
        $newList[] = $list[$i];
    }
    $list = $newList;
}

print_r($list);


echo "total time: ", (microtime(true) - $startTime), "\n";
