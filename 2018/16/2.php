<?php

class device
{
    private $registers;

    public function __construct($register0, $register1, $register2, $register3)
    {
        $this->registers = [
            0 => (int)$register0,
            1 => (int)$register1,
            2 => (int)$register2,
            3 => (int)$register3,
        ];
    }

    public function getRegister($num)
    {
        return $this->registers[$num];
    }

    public function setRegister($num, $value)
    {
        return $this->registers[$num] = $value;
    }

    public function equals(device $device)
    {
        for ($i = 0; $i < 4; $i++) {
            if ($this->getRegister($i) != $device->getRegister($i)) {
                return false;
            }
        }
        return true;
    }
}

class opcode
{
    public static $instructionSet = [
        'addr',
        'addi',
        'mulr',
        'muli',
        'banr',
        'bani',
        'borr',
        'bori',
        'setr',
        'seti',
        'gtir',
        'gtri',
        'gtrr',
        'eqir',
        'eqri',
        'eqrr',
    ];

    public static $candidates = [
         0 => [],
         1 => [],
         2 => [],
         3 => [],
         4 => [],
         5 => [],
         6 => [],
         7 => [],
         8 => [],
         9 => [],
        10 => [],
        11 => [],
        12 => [],
        13 => [],
        14 => [],
        15 => [],
    ];

    public static $translationTable = [];


    public static function addr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) + $device->getRegister($B)
        );
    }

    public static function addi(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) + $B
        );
    }

    public static function mulr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) * $device->getRegister($B)
        );
    }

    public static function muli(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) * $B
        );
    }

    public static function banr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) & $device->getRegister($B)
        );
    }

    public static function bani(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) & $B
        );
    }

    public static function borr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) | $device->getRegister($B)
        );
    }

    public static function bori(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A) | $B
        );
    }

    public static function setr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $device->getRegister($A)
        );
    }

    public static function seti(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            $A
        );
    }

    public static function gtir(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            ($A > $device->getRegister($B) ? 1 : 0)
        );
    }

    public static function gtri(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            ($device->getRegister($A) > $B ? 1 : 0)
        );
    }

    public static function gtrr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            ($device->getRegister($A) > $device->getRegister($B) ? 1 : 0)
        );
    }

    public static function eqir(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            ($A == $device->getRegister($B) ? 1 : 0)
        );
    }

    public static function eqri(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            ($device->getRegister($A) == $B ? 1 : 0)
        );
    }

    public static function eqrr(device $device, $A, $B, $C)
    {
        $device->setRegister(
            $C,
            ($device->getRegister($A) == $device->getRegister($B) ? 1 : 0)
        );
    }
}

class test
{
    const PATTERN = '/.*\[(\d+), (\d+), (\d+), (\d+)\]\s+(\d+) (\d+) (\d+) (\d+).*\[(\d+), (\d+), (\d+), (\d+)\].*/';

    /** @var device */
    private $before;

    /** @var device */
    private $after;

    /** @var int[] */
    private $instructions;

    public function __construct($raw)
    {
        $raw = str_replace("\r\n", ' ', $raw);

        $out = [];
        preg_match(self::PATTERN, $raw, $out);

        $this->before       = new device($out[1], $out[2], $out[3], $out[4]);
        $this->instructions = [$out[5], $out[6], $out[7], $out[8]];
        $this->after        = new device($out[9], $out[10], $out[11], $out[12]);
    }

    public function removeInvalidOpcodes()
    {
        $remainingOpcodes = [];
        #echo ' instructionCode: ', $this->instructions[0];
        #print_r(opcode::$candidates[$this->instructions[0]]);
        foreach (opcode::$candidates[$this->instructions[0]] as $opcode) {
            $in = clone $this->before;
            opcode::$opcode($in, (int)$this->instructions[1], (int)$this->instructions[2], (int)$this->instructions[3]);

            if ($in->equals($this->after)) {
                $remainingOpcodes[] = $opcode;
            }
        }

        if ([] === $remainingOpcodes) {
            throw new RuntimeException('there has to be always at least one left');
        }

        opcode::$candidates[$this->instructions[0]] = $remainingOpcodes;
    }

}

$in = explode("\r\n\r\n", file_get_contents('in1.txt'));

$tests = [];
foreach ($in as $i) {
    $tests[] = new test($i);
}

for ($i = 0; $i < 16; $i++) {
    opcode::$candidates[$i] = opcode::$instructionSet;
}

/** @var test $test */
foreach ($tests as $num => $test)
{
    #echo 'test: ', $num;
    #print_r(opcode::$candidates);
    $test->removeInvalidOpcodes();
    #echo "\n";
}

foreach (opcode::$candidates as $key => $values) {
    echo $key, ': ', implode(',', $values), "\n";
}

while ([] !== opcode::$candidates) {
    $newFixed = '';
    $rest = [];
    foreach (opcode::$candidates as $key => $candidateList) {
        if ($newFixed === '' && count($candidateList) === 1) {
            $newFixed = array_pop($candidateList);
            opcode::$translationTable[$key] = $newFixed;
        } else {
            $rest[$key] = $candidateList;
        }
    }

    opcode::$candidates = [];
    foreach ($rest as $key => $list) {
        opcode::$candidates[$key] = array_diff($list, [$newFixed]);
    }

    //debug
    foreach (opcode::$candidates as $key => $values) {
        echo $key, ': ', implode(',', $values), "\n";
    }
    print_r(opcode::$translationTable);
}

print_r(opcode::$translationTable);

$pattern = '/(\d+) (\d+) (\d+) (\d+)/';

$in = file('in2.txt');
$start = new device(0, 0, 0, 0);
foreach ($in as $key => $line) {
    $out = [];
    preg_match($pattern, $line, $out);

    $opcode = opcode::$translationTable[(int)$out[1]];

    opcode::$opcode($start, (int)$out[2], (int)$out[3], (int)$out[4]);

    echo $key, ': ', $start->getRegister(0), ' ', $start->getRegister(1), ' ', $start->getRegister(2), ' ', $start->getRegister(3), "\n";
}


