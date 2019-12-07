package y2019.d07;

import org.jetbrains.annotations.NotNull;

import java.util.*;

public class Part2 {
    private static final int end = 99;

    private static final int[] small0  = {3,26,1001,26,-4,26,3,27,1002,27,2,27,1,27,26,27,4,27,1001,28,-1,28,1005,28,6,99,0,0,5};   // 139629729  from  9,8,7,6,5
    private static final int[] small1  = {3,52,1001,52,-5,52,3,53,1,52,56,54,1007,54,5,55,1005,55,26,1001,54,-5,54,1105,1,12,1,53,54,53,1008,54,0,55,1001,55,1,55,2,53,55,53,4,53,1001,56,-1,56,1005,56,6,99,0,0,0,0,10};  // 18216  from  9,7,8,5,6
    private static final int[] program = {3,8,1001,8,10,8,105,1,0,0,21,46,55,72,85,110,191,272,353,434,99999,3,9,1002,9,5,9,1001,9,2,9,102,3,9,9,101,2,9,9,102,4,9,9,4,9,99,3,9,102,5,9,9,4,9,99,3,9,1002,9,2,9,101,2,9,9,1002,9,2,9,4,9,99,3,9,1002,9,4,9,101,3,9,9,4,9,99,3,9,1002,9,3,9,101,5,9,9,1002,9,3,9,101,3,9,9,1002,9,5,9,4,9,99,3,9,1001,9,2,9,4,9,3,9,101,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,99,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,99,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,2,9,4,9,99};



    public static void main(String[] args) {

        Set<List<Integer>> allCombinations = getAllPhaseCombinations();

        int max = Integer.MIN_VALUE;

        for (List<Integer> phaseSettings: allCombinations) {
            ArrayList<IntCodeProgram> progs = getNewPrograms(phaseSettings);

            int prevResult = 0;
            int outputCandidate = 0;
            while (prevResult > -1) {
                for (IntCodeProgram prog: progs) {
                    prog.addInput(prevResult);
                    prevResult = prog.run();
                    if (prevResult == -1) {
                        break;
                    }
                }
                if (prevResult != -1) {
                    outputCandidate = prevResult;
                }
            }
            max = Math.max(max, outputCandidate);
        }

        System.out.println(max);
    }

    private static ArrayList<IntCodeProgram> getNewPrograms(List<Integer> phaseSettings) {
        ArrayList<IntCodeProgram> programs = new ArrayList<>();
        IntCodeProgram a = new IntCodeProgram(program); a.addInput(phaseSettings.get(0)); programs.add(a);
        IntCodeProgram b = new IntCodeProgram(program); b.addInput(phaseSettings.get(1)); programs.add(b);
        IntCodeProgram c = new IntCodeProgram(program); c.addInput(phaseSettings.get(2)); programs.add(c);
        IntCodeProgram d = new IntCodeProgram(program); d.addInput(phaseSettings.get(3)); programs.add(d);
        IntCodeProgram e = new IntCodeProgram(program); e.addInput(phaseSettings.get(4)); programs.add(e);
        return programs;
    }

    private static class IntCodeProgram {

        private int[] program;

        private LinkedList<Integer> input = new LinkedList<>();

        private int pointer = 0;

        public IntCodeProgram(int[] program) {
            this.program = program.clone();
        }

        public void addInput(int input) {
            this.input.addLast(input);
        }

        public int run() {
            while (true) {
                if (this.program[this.pointer] == end) {
                    return -1;
                }
                Instruction inst = new Instruction(this.program, this.pointer);
                switch (inst.getOpcode()) {
                    case 1:
                        this.program[inst.getOutPosition()] = inst.getParameterValue1() + inst.getParameterValue2();
                        this.pointer += inst.getStep();
                        break;
                    case 2:
                        this.program[inst.getOutPosition()] = inst.getParameterValue1() * inst.getParameterValue2();
                        this.pointer += inst.getStep();
                        break;
                    case 3:
                        int inp = this.input.removeFirst();
                        this.program[inst.getOutPosition()] = inp;
                        this.pointer += inst.getStep();
                        break;
                    case 4:
                        this.pointer += inst.getStep();
                        return inst.getParameterValue1();
                    case 5:
                        if (inst.getParameterValue1() != 0) {
                            this.pointer = inst.getParameterValue2();
                        } else {
                            this.pointer += inst.getStep();
                        }
                        break;
                    case 6:
                        if (inst.getParameterValue1() == 0) {
                            this.pointer = inst.getParameterValue2();
                        } else {
                            this.pointer += inst.getStep();
                        }
                        break;
                    case 7:
                        if (inst.getParameterValue1() < inst.getParameterValue2()) {
                            this.program[inst.getOutPosition()] = 1;
                        } else {
                            this.program[inst.getOutPosition()] = 0;
                        }
                        this.pointer += inst.getStep();
                        break;
                    case 8:
                        if (inst.getParameterValue1() == inst.getParameterValue2()) {
                            this.program[inst.getOutPosition()] = 1;
                        } else {
                            this.program[inst.getOutPosition()] = 0;
                        }
                        this.pointer += inst.getStep();
                        break;
                }
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
            this.parseInstruction(program[position]);
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
            return this.program[parameterValue1];
        }

        public int getParameterValue2() {
            if (parameterMode2 == 1) {
                return parameterValue2;
            }
            return this.program[parameterValue2];
        }

        public int getParameterValue3() {
            if (parameterMode3 == 1) {
                return parameterValue3;
            }
            return this.program[parameterValue3];
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

    @NotNull
    private static Set<List<Integer>> getAllPhaseCombinations() {
        Set<List<Integer>> allCombinations = new HashSet<>();

        for (int a = 5; a < 10; a++) {
            ArrayList<Integer> tempA = new ArrayList<>();
            tempA.add(a);
            for (int b = 5; b < 10; b++) {
                if (tempA.contains(b)) {
                    continue;
                }
                ArrayList<Integer> tempB = (ArrayList<Integer>) tempA.clone();
                tempB.add(b);
                for (int c = 5; c < 10; c++) {
                    if (tempB.contains(c)) {
                        continue;
                    }
                    ArrayList<Integer> tempC = (ArrayList<Integer>) tempB.clone();
                    tempC.add(c);
                    for (int d = 5; d < 10; d++) {
                        if (tempC.contains(d)) {
                            continue;
                        }
                        ArrayList<Integer> tempD = (ArrayList<Integer>) tempC.clone();
                        tempD.add(d);
                        for (int e = 5; e < 10; e++) {
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
}
