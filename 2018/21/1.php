<?php

class device
{
    const MODE_1 = 1;
    const MODE_2 = 2;

    private $instructionPointer  = 0;
    private $instructionRegister;

    private $program = [];

    private $registers;

    private $mode;

    public function __construct($instructionRegister, $program, $mode = 0)
    {
        $this->instructionRegister = $instructionRegister;

        $this->program = $program;

        $this->registers = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ];

        $this->mode = $mode;
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
        for ($i = 0; $i < 6; $i++) {
            if ($this->getRegister($i) != $device->getRegister($i)) {
                return false;
            }
        }
        return true;
    }

    public function runCommand($name, $A, $B, $C)
    {
        if ($this->mode === self::MODE_1 && 28 === $this->instructionPointer) {
            die ("register content: " . $this->registers[3]);
        }

        echo 'ip=', $this->instructionPointer, ' [', implode(', ', $this->registers), '] ', $name, ' ', $A, ' ', $B, ' ', $C, ' ';
        $this->setRegister($this->instructionRegister, $this->instructionPointer);
        opcode::$name($this, $A, $B, $C);
        $this->instructionPointer = $this->getRegister($this->instructionRegister) + 1;
        echo ' [', implode(', ', $this->registers), "]\n";
    }

    public function run()
    {
        while ($this->instructionPointer < count($this->program)) {
            $command = $this->program[$this->instructionPointer];
            $this->runCommand($command['name'], $command['A'], $command['B'], $command['C']);
        }
    }
}

class opcode
{
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

$program = [];
$register = -1;

$rawProgram = file('in.txt');
$rawRegister = array_shift($rawProgram);
$register = (int)$rawRegister[4];

foreach ($rawProgram as $row) {
    $split = explode(' ', $row);
    if (count($split) !== 4) {
        continue;
    }
    $program[] = [
        'name' =>      $split[0],
        'A'    => (int)$split[1],
        'B'    => (int)$split[2],
        'C'    => (int)$split[3],
    ];
}

$device = new device($register, $program, device::MODE_1);
$device->run();

/*
echo $device->getRegister(0), "\n";
*/