<?php

$program = [];

foreach (file(__DIR__ . '/in.txt') as $row) {
    $program[] = explode(' ', trim($row));
}


class Assembunny {
    private int $pointer = 0;
    private array $register = [
        'a' => 0,
        'b' => 0,
        'c' => 0,
        'd' => 0,
    ];
    private int $yieldCount = 0;

    public function __construct(private array $program)
    {}

    public function run(int $a): Generator
    {
        $this->register['a'] = $a;
        while (isset($this->program[$this->pointer])) {
            $instruction = $this->program[$this->pointer];
            switch ($instruction[0]) {
                case 'inc':
                    $this->register[$instruction[1]]++;
                    $this->pointer++;
                    break;
                case 'dec':
                    $this->register[$instruction[1]]--;
                    $this->pointer++;
                    break;
                case 'cpy':
                    if (is_numeric($instruction[2])) {
                        $this->pointer++;
                        break;
                    }
                    $this->register[$instruction[2]] = is_numeric($instruction[1]) ? (int)$instruction[1] : $this->register[$instruction[1]];
                    $this->pointer++;
                    break;
                case 'jnz':
                    if (is_numeric($instruction[1])) {
                        $checkValue = $instruction[1];
                    } else {
                        $checkValue = $this->register[$instruction[1]];
                    }

                    if (is_numeric($instruction[2])) {
                        $jumpValue = $instruction[2];
                    } else {
                        $jumpValue = $this->register[$instruction[2]];
                    }

                    if ($checkValue != 0) {
                        $this->pointer += $jumpValue;
                    } else {
                        $this->pointer++;
                    }

                    break;
                case 'tgl':
                    $offset = is_numeric($instruction[1]) ? $instruction[1] : $this->register[$instruction[1]];
                    if (!isset($this->program[$this->pointer + $offset])) {
                        $this->pointer++;
                        break;
                    }
                    if (count($this->program[$this->pointer + $offset]) === 2) {
                        if ($this->program[$this->pointer + $offset][0] === 'inc') {
                            $this->program[$this->pointer + $offset][0] = 'dec';
                        } else {
                            $this->program[$this->pointer + $offset][0] = 'inc';
                        }
                    } else if (count($this->program[$this->pointer + $offset]) === 3) {
                        if ($this->program[$this->pointer + $offset][0] === 'jnz') {
                            $this->program[$this->pointer + $offset][0] = 'cpy';
                        } else {
                            $this->program[$this->pointer + $offset][0] = 'jnz';
                        }
                    }
                    $this->pointer++;
                    break;
                case 'out':
                    if (is_numeric($instruction[1])) {
                        yield $this->yieldCount++ => $instruction[1];
                    } else {
                        yield $this->yieldCount++ => $this->register[$instruction[1]];
                    }
                    $this->pointer++;
                    break;
                default:
                    throw new RuntimeException('Dude, WTF?! -- ' . print_r($this->program[$this->pointer], true));
            }
        }
        throw new RuntimeException('program quit unexpectedly');
    }
}

$ass_M_bunny = new Assembunny($program);
foreach ($ass_M_bunny->run(196) as $i => $o) {
    echo "$i - $o\n";
}

