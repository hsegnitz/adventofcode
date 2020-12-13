<?php

$startTime = microtime(true);

class Elf
{
    private int $id;
    private Elf $previous;
    private Elf $next;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNext(Elf $next): void
    {
        $this->next = $next;
        $this->next->setPrevious($this);
    }

    public function getNext(): Elf
    {
        return $this->next;
    }

    public function setPrevious(Elf $previous): void
    {
        $this->previous = $previous;
    }

    public function removeSelfAndReturnNext(): self
    {
        $this->previous->setNext($this->next);
        return $this->getNext();
    }
}

// 2020-12-31 -- with php 7.4 on ubuntu20.04-lts through WSL2 creating the doubly linked list further on
// creates a segfault crash every other run, so reserving a huge block of ram immediately seems to solve it.
#$blockHugeAmountOfRam = range(0, 30184580);
#unset($blockHugeAmountOfRam);


/*

$input = 5; // 2
$input = 7; // 5
$input = 9; // 9
$input = 11; // 2
$input = 15; // 6
$input = 17; // 8
$input = 19; // 11
$input = 25; // 23
$input = 27; // 27
$input = 29; // 2
$input = 45; // 18
$input = 53; // 26
$input = 55; // 29
 *
 *
 *
/*    */


$size = 3018458; // 5   //3018458

$firstVictimAtId = (int)floor($size/2)+1;

$first = $current = new Elf(1);
for ($i = 2; $i <= $size; $i++) {
    $next = new Elf($i);
    if ($i === $firstVictimAtId) {
        $firstVictim = $next;
    }
    $current->setNext($next);
    $current = $next;
}

$current->setNext($first);

$currentElf = $firstVictim;
while ($size > 1) {
    $currentElf = $currentElf->removeSelfAndReturnNext();
    --$size;
    if ($size % 2 === 0) {
        $currentElf = $currentElf->getNext();
    }
}

echo $currentElf->getId();

echo "total time: ", (microtime(true) - $startTime), "\n";
