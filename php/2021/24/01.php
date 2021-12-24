<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$program = [];
foreach ($input as $line) {
    $program[] = explode(' ', $line);
}




class ALU
{
    private int $w = 0;
    private int $x = 0;
    private int $y = 0;
    private int $z = 0;

    private array $input;

    public function __construct(
        private array $program,
    ) {}

    public function run(string $input): bool {
        $this->input = str_split($input);
        $this->w = $this->x = $this->y = $this->z = 0;
        foreach ($this->program as $instruction) {
            switch ($instruction[0]) {
                case 'inp':
                    $this->inp($instruction[1]);
                    break;
                case 'add':
                case 'mul':
                case 'div':
                case 'mod':
                case 'eql':
                    $this->{$instruction[0]}($instruction[1], $instruction[2]);
                    break;
                default:
                    throw new RuntimeException('invalid instruction: ' . $instruction[0]);
            }
        }

        return $this->z === 0;
    }

    private function inp(string $a): void
    {
        $this->$a = (int)array_shift($this->input);
    }

    private function add(string $a, mixed $b): void
    {
        if (is_numeric($b)) {
            $this->$a += (int)$b;
            return;
        }
        $this->$a += $this->$b;
    }

    private function mul(string $a, mixed $b): void
    {
        if (is_numeric($b)) {
            $this->$a *= (int)$b;
            return;
        }
        $this->$a *= $this->$b;
    }

    private function div(string $a, mixed $b): void
    {
        if (is_numeric($b)) {
            if ((int)$b === 0) {
                throw new RuntimeException('div by zero');
            }
            $temp = $this->$a / (int)$b;
        } else {
            if ($this->$b === 0) {
                throw new RuntimeException('div by zero');
            }
            $temp = $this->$a / $this->$b;
        }
        $this->$a = floor($temp);
    }

    private function mod(string $a, mixed $b): void
    {
        if ($this->$a < 0) {
            throw new RuntimeException('THIS cannot mod on below 0');
        }

        if (is_numeric($b)) {
            if ($b < 0) {
                throw new RuntimeException('cannot mod by below or equal to 0');
            }
            $this->$a %= (int)$b;
            return;
        }

        if ($this->$b < 0) {
            throw new RuntimeException('cannot mod by below or equal to 0');
        }
        $this->$a %= $this->$b;
    }

    private function eql(string $a, mixed $b): void
    {
        if (is_numeric($b)) {
            $this->$a = $this->$a === (int)$b ? 1 : 0;
            return;
        }
        $this->$a = $this->$a === $this->$b ? 1 : 0;
    }
}

$alu = new ALU($program);
#for ($i = 11111111111111; $i < 100000000000000; $i++) {
#for ($i = 100000000000000; $i > 11111111111111 ; --$i) {
#    if (str_contains((string)$i, '0')) {
#        continue;
#    }

if ($alu->run("97919997299495")) {
    echo "success\n";
}

if ($alu->run("51619131181131")) {
    echo "success\n";
}
#}

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

