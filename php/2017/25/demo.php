<?php

$startTime = microtime(true);

class TuringMachineDemo
{
    private array $tape = [];

    private string $next = 'A';

    private int $position = 0;

    private function A(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            ++$this->position;
        } else {
            $this->tape[$this->position] = 0;
            --$this->position;
        }
        $this->next = 'B';
    }

    private function B(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            --$this->position;
        } else {
            $this->tape[$this->position] = 1;
            ++$this->position;
        }
        $this->next = 'A';
    }

    public function tick(): void
    {
        $this->{$this->next}();
    }

    public function checksum(): int
    {
        return array_sum($this->tape);
    }
}

$tmd = new TuringMachineDemo();

for ($i = 0; $i < 6; $i++) {
    $tmd->tick();
}

echo $tmd->checksum();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
