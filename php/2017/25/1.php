<?php

$startTime = microtime(true);

class TuringMachine
{
    private array $tape = [];

    private string $next = 'A';

    private int $position = 0;

    private function A(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            ++$this->position;
            $this->next = 'B';
        } else {
            $this->tape[$this->position] = 0;
            ++$this->position;
            $this->next = 'F';
        }
    }

    private function B(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 0;
            --$this->position;
            $this->next = 'B';
        } else {
            $this->tape[$this->position] = 1;
            --$this->position;
            $this->next = 'C';
        }
    }

    private function C(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            --$this->position;
            $this->next = 'D';
        } else {
            $this->tape[$this->position] = 0;
            ++$this->position;
            $this->next = 'C';
        }
    }

    private function D(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            --$this->position;
            $this->next = 'E';
        } else {
            $this->tape[$this->position] = 1;
            ++$this->position;
            $this->next = 'A';
        }
    }

    private function E(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            --$this->position;
            $this->next = 'F';
        } else {
            $this->tape[$this->position] = 0;
            --$this->position;
            $this->next = 'D';
        }
    }

    private function F(): void
    {
        if (!isset($this->tape[$this->position]) || $this->tape[$this->position] === 0) {
            $this->tape[$this->position] = 1;
            ++$this->position;
            $this->next = 'A';
        } else {
            $this->tape[$this->position] = 0;
            --$this->position;
            $this->next = 'E';
        }
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

$tm = new TuringMachine();

for ($i = 0; $i < 12964419; $i++) {
    $tm->tick();
}

echo $tm->checksum();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
