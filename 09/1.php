<?php

gc_disable();

ini_set('memory_limit', '5G');

// $numPlayers = 9; $marbles    = 25;
// $numPlayers = 10; $marbles    = 1618;
// $numPlayers = 13; $marbles    = 7999;
// $numPlayers = 17; $marbles    = 1104;
// $numPlayers = 21; $marbles    = 6111;
// $numPlayers = 30; $marbles    = 5807;
// $numPlayers = 459; $marbles    = 71320;
$numPlayers = 459; $marbles    = 7132000;

$scores = array_fill(0, $numPlayers, 0);

class marble
{
    private $value = 0;

    /** @var marble */
    private $previous;

    /** @var marble */
    private $next;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setPrevious(marble $previous)
    {
        $this->previous = $previous;
    }

    public function setNext(marble $next)
    {
        $this->next = $next;
    }

    public function addAfter(marble $marble)
    {
        $marble->setNext($this->next);
        $this->next->setPrevious($marble);
        $marble->setPrevious($this);
        $this->next = $marble;
    }

    public function remove()
    {
        $this->previous->setNext($this->next);
        $this->next->setPrevious($this->previous);
    }

    public function getNext()
    {
        return $this->next;
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function debug()
    {
        $current = $this;
        do {
            echo $current->getValue(), ' ';
            $current = $current->getNext();
        } while ($current !== $this);
    }
}

// initialize
$first = new marble(0);
$first->setNext($first);
$first->setPrevious($first);

/* */
$current = $first;

for ($turn = 1; $turn <= $marbles; $turn++) {
    $newMarble = new marble($turn);
    if ($turn % 23 !== 0) {
        $current->getNext()->addAfter($newMarble);
        $current = $newMarble;
    } else {
        $sevenPrevious = $current->getPrevious()->getPrevious()->getPrevious()->getPrevious()->getPrevious()->getPrevious()->getPrevious();
        $score = $newMarble->getValue();
        $score +=  $sevenPrevious->getValue();
        $current = $sevenPrevious->getNext();
        $sevenPrevious->remove();
        $scores[$turn%$numPlayers] += $score;
    }

/*    echo '[', $turn, ']  ';
    $first->debug();
    echo "\n";*/
}

print_r($scores);

echo "\n", max($scores), "\n";

/* */