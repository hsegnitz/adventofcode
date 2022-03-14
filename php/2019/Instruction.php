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
        $this->parseInstruction(program.get(position));
        switch (opcode) {
            case 1:
            case 2:
            case 7:
            case 8:
                $step = 4;
                parameterValue1 = program.get(position + 1);
                parameterValue2 = program.get(position + 2);
                outPosition = program.get(position + 3);
                outParameterMode = parameterMode3;
                break;
            case 3:
                $step = 2;
                outPosition = program.get(position + 1);
                outParameterMode = parameterMode1;
                break;
            case 4:
            case 9:
                $step = 2;
                parameterValue1 = program.get(position + 1);
                break;
            case 5:
            case 6:
                $step = 3;
                parameterValue1 = program.get(position + 1);
                parameterValue2 = program.get(position + 2);
                outParameterMode = parameterMode2;
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
        this.opcode = Integer.parseInt(temp.substring(temp.length() - 2));
        if (temp.length() > 2) {
            this.parameterMode1 = Integer.parseInt(temp.substring(temp.length() - 3, temp.length() - 2));
        }
        if (temp.length() > 3) {
            this.parameterMode2 = Integer.parseInt(temp.substring(temp.length() - 4, temp.length() - 3));
        }
        if (temp.length() > 4) {
            this.parameterMode3 = Integer.parseInt(temp.substring(temp.length() - 5, temp.length() - 4));
        }
    }


    public function getOpcode(): int
    {
        return $this->opcode;
    }

    public function getStep(): int {
        return $this->step;
    }

    public long getParameterValue1(long offset) {
        if (parameterMode1 == 1) {
            return parameterValue1;
        }

        long posi = parameterValue1;
        if (parameterMode1 == 2) {
            posi += offset;
        }
        if (this.program.containsKey(posi)) {
            return this.program.get(posi);
        }
        return 0L;
    }

    public long getParameterValue2(long offset) {
        if (parameterMode2 == 1) {
            return parameterValue2;
        }

        long posi = parameterValue2;
        if (parameterMode2 == 2) {
            posi += offset;
        }
        if (this.program.containsKey(posi)) {
            return this.program.get(posi);
        }
        return 0L;
    }

    public long getParameterValue3(long offset) {
        if (parameterMode3 == 1) {
            return parameterValue3;
        }

        long posi = parameterValue3;
        if (parameterMode3 == 2) {
            posi += offset;
        }
        if (this.program.containsKey(posi)) {
            return this.program.get(posi);
        }
        return 0L;
    }

    public long getOutPosition(long offset) {
        if (outParameterMode == 2) {
            return outPosition+offset;
        }
        return outPosition;
    }

}
