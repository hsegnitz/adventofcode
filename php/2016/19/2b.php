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
        return $this;
    }
}

// 2020-12-31 -- with php 7.4 on ubuntu20.04-lts through WSL2 creating the doubly linked list further on
// creates a segfault crash every other run, so reserving a huge block of ram immediately seems to solve it.
$blockHugeAmountOfRam = range(0, 30184580);
unset($blockHugeAmountOfRam);

$size = 3018458; // 5   //3018458

$first = $current = new Elf(1);
for ($i = 2; $i <= $size; $i++) {
    $next = new Elf($i);
    $current->setNext($next);
    $current = $next;
}

$current->setNext($first);

$currentElf = $first;
while ($size > 1) {
    $loopcount = floor($size/2);
    while (--$loopcount >= 0) {
        $currentElf = $currentElf->getNext();
    }
    $currentElf = $currentElf->removeSelfAndReturnNext();
    --$size;
    if ($size % 100 === 0) {
        echo $size, ": ", (microtime(true) - $startTime), "\n";
    }

}

echo $currentElf->getId();

echo "total time: ", (microtime(true) - $startTime), "\n";
