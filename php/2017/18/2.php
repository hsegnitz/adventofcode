<?php

$startTime = microtime(true);

#$input = file_get_contents('./demo.txt');
$input = file_get_contents('./in.txt');

$input = explode("\n", $input);
$program = [];
foreach ($input as $row) {
    $program[] = explode(' ', $row);
}

class Singer {
    private int $pointer = 0;
    private array $register = [
        'a' => 0,
        'b' => 0,
        'f' => 0,
        'i' => 0,
        'p' => 0,
    ];

    private array $inputQueue = [];

    public function __construct(private array $program, int $number)
    {
        $this->register['p'] = $number;
    }

    public function addToQueue(int $value): void
    {
        $this->inputQueue[] = $value;
    }

    private function numOrRegisterContent(string $var): int
    {
        if (is_numeric($var)) {
            return (int) $var;
        }
        if (isset($this->register[$var])) {
            return (int)$this->register[$var];
        }
        throw new InvalidArgumentException('Unable to process parameter ' . $var);
    }

    public function run(): Generator
    {
        while (isset($this->program[$this->pointer])) {
            $instruction = $this->program[$this->pointer];
            switch ($instruction[0]) {
                case 'snd':
                    yield $this->numOrRegisterContent($instruction[1]);
                    $this->pointer++;
                    break;
                case 'set':
                    $this->register[$instruction[1]] = $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    break;
                case 'add':
                    $this->register[$instruction[1]] += $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    break;
                case 'mul':
                    $this->register[$instruction[1]] *= $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    break;
                case 'mod':
                    $this->register[$instruction[1]] %= $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    break;
                case 'rcv':
                    if (count($this->inputQueue) < 1) {
                        return;
                    }
                    $this->register[$instruction[1]] = array_shift($this->inputQueue);
                    $this->pointer++;
                    break;
                case 'jgz':
                    if ($this->numOrRegisterContent($instruction[1]) > 0) {
                        $this->pointer += $this->numOrRegisterContent($instruction[2]);
                    } else {
                        $this->pointer++;
                    }
                    break;
                default:
                    throw new RuntimeException('Dude, WTF?! -- ' . $instruction[0]);
            }
        }
        throw new RuntimeException('program quit unexpectedly');
    }
}

$program0 = new Singer($program, 0);
$program1 = new Singer($program, 1);

$count = 0;
$bothWaiting = false;
while ($bothWaiting === false) {
    $bothWaiting = true;
    foreach ($program0->run() as $output) {
        $program1->addToQueue($output);
        $bothWaiting = false;
    }
    foreach ($program1->run() as $output) {
        $program0->addToQueue($output);
        $bothWaiting = false;
        ++$count;
    }
}

echo $count;

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


