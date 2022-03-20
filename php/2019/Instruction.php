<?php

class Instruction {

    private int $opcode;
    private int $step;

    private int $parameterMode1   = 0;
    private int $parameterMode2   = 0;
    private int $parameterMode3   = 0;
    private int $outParameterMode = 0;

    /**
     * either a literal value or a position, depending on parameter mode being 0 or 1
     */
    private int $parameterValue1;
    private int $parameterValue2;
    private int $parameterValue3;

    private int $outPosition;

    public function __construct(private IntCodeProgram $program, int $position)
    {
        $this->parseInstruction($program->get($position));
        switch ($this->opcode) {
            case 1:
            case 2:
            case 7:
            case 8:
                $this->step = 4;
                $this->parameterValue1  = $program->get($position + 1);
                $this->parameterValue2  = $program->get($position + 2);
                $this->outPosition      = $program->get($position + 3);
                $this->outParameterMode = $this->parameterMode3;
                break;
            case 3:
                $this->step = 2;
                $this->outPosition = $program->get($position + 1);
                $this->outParameterMode = $this->parameterMode1;
                break;
            case 4:
            case 9:
                $this->step = 2;
                $this->parameterValue1 = $program->get($position + 1);
                break;
            case 5:
            case 6:
                $this->step = 3;
                $this->parameterValue1  = $program->get($position + 1);
                $this->parameterValue2  = $program->get($position + 2);
                $this->outParameterMode = $this->parameterMode2;
                break;
        }
    }

    private function parseInstruction(int $instruction): void
    {
        if ($instruction <= 99) {
            $this->opcode = $instruction;
            return;
        }

        $temp = (string)$instruction;
        $length = strlen($temp);

        $this->opcode = (int)substr($temp, -2);
        if ($length > 2) {
            $this->parameterMode1 = (int)$temp[$length - 3];
        }
        if ($length > 3) {
            $this->parameterMode2 = (int)$temp[$length - 4];
        }
        if ($length > 4) {
            $this->parameterMode3 = (int)$temp[$length - 5];
        }
    }


    public function getOpcode(): int
    {
        return $this->opcode;
    }

    public function getStep(): int {
        return $this->step;
    }

    public function getParameterValue1(int $offset): int
    {
        if ($this->parameterMode1 === 1) {
            return $this->parameterValue1;
        }

        $posi = $this->parameterValue1;
        if ($this->parameterMode1 === 2) {
            $posi += $offset;
        }
        if ($this->program->containsKey($posi)) {
            return $this->program->get($posi);
        }
        return 0;
    }

    public function getParameterValue2(int $offset): int
    {
        if ($this->parameterMode2 === 1) {
            return $this->parameterValue2;
        }

        $posi = $this->parameterValue2;
        if ($this->parameterMode2 === 2) {
            $posi += $offset;
        }
        if ($this->program->containsKey($posi)) {
            return $this->program->get($posi);
        }
        return 0;
    }

    public function getParameterValue3(int $offset): int
    {
        if ($this->parameterMode3 === 1) {
            return $this->parameterValue3;
        }

        $posi = $this->parameterValue3;
        if ($this->parameterMode3 === 2) {
            $posi += $offset;
        }
        if ($this->program->containsKey($posi)) {
            return $this->program->get($posi);
        }
        return 0;
    }

    public function getOutPosition(int $offset): int
    {
        if ($this->outParameterMode === 2) {
            return $this->outPosition + $offset;
        }
        return $this->outPosition;
    }
}
