<?php

$startTime = microtime(true);

$input = file_get_contents('./in.txt');

$input = explode("\n", $input);
$program = [];
foreach ($input as $row) {
    $program[] = explode(' ', $row);
}

class Program {
    private int $pointer = 0;
    private array $register = [
        'a' => 0,
        'b' => 0,
        'c' => 0,
        'd' => 0,
        'e' => 0,
        'f' => 0,
        'g' => 0,
        'h' => 0,
    ];

    public function __construct(private array $program)
    {}

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

    public function run(): int
    {
        $mulCount = 0;
        while (isset($this->program[$this->pointer])) {
            $instruction = $this->program[$this->pointer];
            switch ($instruction[0]) {
                case 'set':
                    $this->register[$instruction[1]] = $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    break;
                case 'sub':
                    $this->register[$instruction[1]] -= $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    break;
                case 'mul':
                    $this->register[$instruction[1]] *= $this->numOrRegisterContent($instruction[2]);
                    $this->pointer++;
                    ++$mulCount;
                    break;
                case 'jnz':
                    if ($this->numOrRegisterContent($instruction[1]) !== 0) {
                        $this->pointer += $this->numOrRegisterContent($instruction[2]);
                    } else {
                        $this->pointer++;
                    }
                    break;
                default:
                    throw new RuntimeException('Dude, WTF?! -- ' . $instruction[0]);
            }
        }
        # throw new RuntimeException('program quit unexpectedly');
        return $mulCount;
    }
}

$program = new Program($program);

echo $program->run();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


