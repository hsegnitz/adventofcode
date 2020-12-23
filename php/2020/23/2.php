<?php

$startTime = microtime(true);

class Cup
{
    private int $id;
    private Cup $next;
    private Cup $previous;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function setPrevious(Cup $previous): void
    {
        $this->previous = $previous;
    }

    public function setNext(Cup $next): void
    {
        $this->next = $next;
        $next->setPrevious($this);
    }

    public function remove(): void
    {
        $this->previous->setNext($this->next);
    }

    public function insertAfterThis(Cup $next): void
    {
        $next->setNext($this->next);
        $next->setPrevious($this);
        $this->next = $next;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNext(): Cup
    {
        return $this->next;
    }

    public function getPrevious(): Cup
    {
        return $this->previous;
    }
}

#$input = '389125467';
$cupLimit = 1000000;
$input = '916438275';
$moves = 10000000;

/** @var Cup[] $cupsById */
$cupsById = [];
foreach (str_split($input) as $value) {
    $newCup = new Cup($value);
    $cupsById[$value] = $newCup;
    if (isset($previousCup)) {
        $previousCup->setNext($newCup);
    }
    $previousCup = $newCup;
}

for ($i = 10; $i <= $cupLimit; $i++) {
    $newCup = new Cup($i);
    $cupsById[$i] = $newCup;
    if (isset($previousCup)) {
        $previousCup->setNext($newCup);
    }
    $previousCup = $newCup;
}

$first = $cupsById[array_key_first($cupsById)];
$previousCup->setNext($first);

/*
echo $first->getPrevious()->getPrevious()->getId();
die();
*/


$i = 0;
$cup = $cupsById[array_key_first($cupsById)];
while ($i++ < 20) {
    echo $cup->getId(), " ";
    $cup = $cup->getNext();
}
echo "\n";



function moveCups(array $cupsById, Cup $current): void
{
    $first = $current->getNext();
    $first->remove();
    $second = $first->getNext();
    $second->remove();
    $third = $second->getNext();
    $third->remove();

    $pulledIds = [
        $first->getId(),
        $second->getId(),
        $third->getId(),
    ];

    $insertAfterId = $current->getId()-1;
    while ($insertAfterId < 1 || in_array($insertAfterId, $pulledIds)) {
        if ($insertAfterId-- < 1) {
            $insertAfterId = 1000000;
        }
    }

    $cupToInsertAfter = $cupsById[$insertAfterId];
    $cupToInsertAfter->insertAfterThis($third);
    $cupToInsertAfter->insertAfterThis($second);
    $cupToInsertAfter->insertAfterThis($first);
}

$current = $cupsById[array_key_first($cupsById)];

$move = 0;
while (++$move <= $moves) {
    #echo "(", $current->getId(), ") ";
    moveCups($cupsById, $current);

/*    $i = 0;
    $cup = $cupsById[array_key_first($cupsById)];
    while ($i++ < 20) {
        echo $cup->getId(), " ";
        $cup = $cup->getNext();
    }
    echo "\n";
*/
    $current = $current->getNext();
}

echo "Output according to rules: ";
$one = $cupsById[1];
$next = $one->getNext();
$second = $next->getNext();

echo $next->getId(), " ", $second->getId(), ": ", ($next->getId() * $second->getId());


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
