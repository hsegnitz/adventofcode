package y2019.d07;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

public class Part1 {
    private static final int end = 99;

    private static final int[] small0  = {3,15,3,16,1002,16,10,16,1,16,15,15,4,15,99,0,0};   // 43210 from 4,3,2,1,0
    private static final int[] small1  = {3,23,3,24,1002,24,10,24,1002,23,-1,23,101,5,23,23,1,24,23,23,4,23,99,0,0};  // 54321  from  0,1,2,3,4
    private static final int[] small2  = {3,31,3,32,1002,32,10,32,1001,31,-2,31,1007,31,0,33,1002,33,7,33,1,33,31,31,1,32,31,31,4,31,99,0,0,0};  // 65210   from   1,0,4,3,2
    private static final int[] program = {3,8,1001,8,10,8,105,1,0,0,21,46,55,72,85,110,191,272,353,434,99999,3,9,1002,9,5,9,1001,9,2,9,102,3,9,9,101,2,9,9,102,4,9,9,4,9,99,3,9,102,5,9,9,4,9,99,3,9,1002,9,2,9,101,2,9,9,1002,9,2,9,4,9,99,3,9,1002,9,4,9,101,3,9,9,4,9,99,3,9,1002,9,3,9,101,5,9,9,1002,9,3,9,101,3,9,9,1002,9,5,9,4,9,99,3,9,1001,9,2,9,4,9,3,9,101,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,99,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,99,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,2,9,4,9,99};

    public static void main(String[] args) {

        Set<List<Integer>> allCombinations = getAllPhaseCombinations();

        // System.out.println(allCombinations.size());

        int[] phaseSettings = new int[5];

    //    run(small0, );

     }

    @NotNull
    private static Set<List<Integer>> getAllPhaseCombinations() {
        Set<List<Integer>> allCombinations = new HashSet<>();

        for (int a = 0; a < 5; a++) {
            ArrayList<Integer> tempA = new ArrayList<>();
            tempA.add(a);
            for (int b = 0; b < 5; b++) {
                if (tempA.contains(b)) {
                    continue;
                }
                ArrayList<Integer> tempB = (ArrayList<Integer>) tempA.clone();
                tempB.add(b);
                for (int c = 0; c < 5; c++) {
                    if (tempB.contains(c)) {
                        continue;
                    }
                    ArrayList<Integer> tempC = (ArrayList<Integer>) tempB.clone();
                    tempC.add(c);
                    for (int d = 0; d < 5; d++) {
                        if (tempC.contains(d)) {
                            continue;
                        }
                        ArrayList<Integer> tempD = (ArrayList<Integer>) tempC.clone();
                        tempD.add(d);
                        for (int e = 0; e < 5; e++) {
                            if (tempD.contains(e)) {
                                continue;
                            }
                            ArrayList<Integer> tempE = (ArrayList<Integer>) tempD.clone();
                            tempE.add(e);
                            allCombinations.add(tempE);
                        }
                    }
                }
            }
        }
        return allCombinations;
    }

    private static int run(@NotNull int[] program, int[] input) {
        int inputPointer = 0;
        int pointer = 0;
        int output  = -1;
        while (true) {
            if (program[pointer] == end) {
                return output;
            }
            Instruction inst = new Instruction(program, pointer);
            switch (inst.getOpcode()) {
                case 1:
                    program[inst.getOutPosition()] = inst.getParameterValue1() + inst.getParameterValue2();
                    pointer += inst.getStep();
                    break;
                case 2:
                    program[inst.getOutPosition()] = inst.getParameterValue1() * inst.getParameterValue2();
                    pointer += inst.getStep();
                    break;
                case 3:
                    program[inst.getOutPosition()] = input[inputPointer++];
                    pointer += inst.getStep();
                    break;
                case 4:
                    output = inst.getParameterValue1();
                    pointer += inst.getStep();
                    break;
                case 5:
                    if (inst.getParameterValue1() != 0) {
                        pointer = inst.getParameterValue2();
                    } else {
                        pointer += inst.getStep();
                    }
                    break;
                case 6:
                    if (inst.getParameterValue1() == 0) {
                        pointer = inst.getParameterValue2();
                    } else {
                        pointer += inst.getStep();
                    }
                    break;
                case 7:
                    if (inst.getParameterValue1() < inst.getParameterValue2()) {
                        program[inst.getOutPosition()] = 1;
                    } else {
                        program[inst.getOutPosition()] = 0;
                    }
                    pointer += inst.getStep();
                    break;
                case 8:
                    if (inst.getParameterValue1() == inst.getParameterValue2()) {
                        program[inst.getOutPosition()] = 1;
                    } else {
                        program[inst.getOutPosition()] = 0;
                    }
                    pointer += inst.getStep();
                    break;
            }
        }
    }


    private static class Instruction {
        private int[] program;
        private int opcode;
        private int step;

        private int parameterMode1 = 0;
        private int parameterMode2 = 0;
        private int parameterMode3 = 0;

        /**
         * either a literal value or a position, depending on parameter mode being 0 or 1
         */
        private int parameterValue1;
        private int parameterValue2;
        private int parameterValue3;

        private int outPosition;

        public Instruction(int[] program, int position) {
            this.program = program;
            parseInstruction(program[position]);
            switch (opcode) {
                case 1:
                case 2:
                case 7:
                case 8:
                    step = 4;
                    parameterValue1 = program[position + 1];
                    parameterValue2 = program[position + 2];
                    outPosition = program[position + 3];
                    break;
                case 3:
                    step = 2;
                    outPosition = program[position + 1];
                    break;
                case 4:
                    step = 2;
                    parameterValue1 = program[position + 1];
                    break;
                case 5:
                case 6:
                    step = 3;
                    parameterValue1 = program[position + 1];
                    parameterValue2 = program[position + 2];
                    break;
            }
        }

        public int getOpcode() {
            return opcode;
        }

        public int getStep() {
            return step;
        }

        public int getParameterValue1() {
            if (parameterMode1 == 1) {
                return parameterValue1;
            }
            return program[parameterValue1];
        }

        public int getParameterValue2() {
            if (parameterMode2 == 1) {
                return parameterValue2;
            }
            return program[parameterValue2];
        }

        public int getParameterValue3() {
            if (parameterMode3 == 1) {
                return parameterValue3;
            }
            return program[parameterValue3];
        }

        public int getOutPosition() {
            return outPosition;
        }

        private void parseInstruction(Integer instruction) {
            if (instruction <= 99) {
                this.opcode = instruction;
                return;
            }

            String temp = instruction.toString();
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
    }
}
