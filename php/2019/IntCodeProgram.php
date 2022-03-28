<?php

class IntCodeProgram
{
    private const END = 99;

    private array $input = [];

    private int $pointer = 0;

    private int $relativeBaseOffset = 0;

    public function __construct(private array $program, private ?Closure $inputFunction = null)
    {
    }

    public function addInput(int $input): void
    {
        $this->input[] = $input;
    }

    public function get(int $position): int
    {
        return $this->program[$position];
    }

    public function containsKey(int $position): bool
    {
        return isset($this->program[$position]);
    }

    public function run(): int
    {
        while (true) {
            if ($this->program[$this->pointer] === self::END) {
                return -2;
            }
            $inst = new Instruction($this, $this->pointer);
            switch ($inst->getOpcode()) {
                case 1:
                    $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = $inst->getParameterValue1($this->relativeBaseOffset) + $inst->getParameterValue2($this->relativeBaseOffset);
                    $this->pointer += $inst->getStep();
                    break;
                case 2:
                    $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = $inst->getParameterValue1($this->relativeBaseOffset) * $inst->getParameterValue2($this->relativeBaseOffset);
                    $this->pointer += $inst->getStep();
                    break;
                case 3:
                    if (null !== $this->inputFunction) {
                        $inp = $this->inputFunction->call($this);
                    } else {
                        $inp = array_shift($this->input);
                    }
                    $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = $inp;
                    $this->pointer += $inst->getStep();
                    break;
                case 4:
                    $this->pointer += $inst->getStep();
                    return $inst->getParameterValue1($this->relativeBaseOffset);
                case 5:
                    if ($inst->getParameterValue1($this->relativeBaseOffset) !== 0) {
                        $this->pointer = $inst->getParameterValue2($this->relativeBaseOffset);
                    } else {
                        $this->pointer += $inst->getStep();
                    }
                    break;
                case 6:
                    if ($inst->getParameterValue1($this->relativeBaseOffset) === 0) {
                        $this->pointer = $inst->getParameterValue2($this->relativeBaseOffset);
                    } else {
                        $this->pointer += $inst->getStep();
                    }
                    break;
                case 7:
                    if ($inst->getParameterValue1($this->relativeBaseOffset) < $inst->getParameterValue2($this->relativeBaseOffset)) {
                        $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = 1;
                    } else {
                        $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = 0;
                    }
                    $this->pointer += $inst->getStep();
                    break;
                case 8:
                    if ($inst->getParameterValue1($this->relativeBaseOffset) === $inst->getParameterValue2($this->relativeBaseOffset)) {
                        $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = 1;
                    } else {
                        $this->program[$inst->getOutPosition($this->relativeBaseOffset)] = 0;
                    }
                    $this->pointer += $inst->getStep();
                    break;
                case 9:
                    $this->relativeBaseOffset += $inst->getParameterValue1($this->relativeBaseOffset);
                    $this->pointer += $inst->getStep();
                    break;
            }
        }
    }
}
