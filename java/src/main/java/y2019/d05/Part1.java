package y2019.d05;

import org.jetbrains.annotations.NotNull;

public class Part1 {
    private static final int end = 99;

    private static final int[] small0 = {3,0,4,0,99};
    private static final int[] small1 = {1002,4,3,4,33};
    private static final int[] small2 = {1101,100,-1,4,0};
    private static final int[] input  = {3,225,1,225,6,6,1100,1,238,225,104,0,1101,40,27,224,101,-67,224,224,4,224,1002,223,8,223,1001,224,2,224,1,224,223,223,1101,33,38,225,1102,84,60,225,1101,65,62,225,1002,36,13,224,1001,224,-494,224,4,224,1002,223,8,223,1001,224,3,224,1,223,224,223,1102,86,5,224,101,-430,224,224,4,224,1002,223,8,223,101,6,224,224,1,223,224,223,1102,23,50,225,1001,44,10,224,101,-72,224,224,4,224,102,8,223,223,101,1,224,224,1,224,223,223,102,47,217,224,1001,224,-2303,224,4,224,102,8,223,223,101,2,224,224,1,223,224,223,1102,71,84,225,101,91,40,224,1001,224,-151,224,4,224,1002,223,8,223,1001,224,5,224,1,223,224,223,1101,87,91,225,1102,71,19,225,1,92,140,224,101,-134,224,224,4,224,1002,223,8,223,101,1,224,224,1,224,223,223,2,170,165,224,1001,224,-1653,224,4,224,1002,223,8,223,101,5,224,224,1,223,224,223,1101,49,32,225,4,223,99,0,0,0,677,0,0,0,0,0,0,0,0,0,0,0,1105,0,99999,1105,227,247,1105,1,99999,1005,227,99999,1005,0,256,1105,1,99999,1106,227,99999,1106,0,265,1105,1,99999,1006,0,99999,1006,227,274,1105,1,99999,1105,1,280,1105,1,99999,1,225,225,225,1101,294,0,0,105,1,0,1105,1,99999,1106,0,300,1105,1,99999,1,225,225,225,1101,314,0,0,106,0,0,1105,1,99999,1107,226,677,224,1002,223,2,223,1006,224,329,101,1,223,223,8,226,226,224,1002,223,2,223,1005,224,344,101,1,223,223,1007,677,226,224,102,2,223,223,1005,224,359,101,1,223,223,8,226,677,224,102,2,223,223,1005,224,374,101,1,223,223,1107,677,677,224,1002,223,2,223,1005,224,389,1001,223,1,223,108,226,677,224,102,2,223,223,1005,224,404,1001,223,1,223,108,677,677,224,1002,223,2,223,1006,224,419,101,1,223,223,107,677,677,224,102,2,223,223,1006,224,434,101,1,223,223,108,226,226,224,1002,223,2,223,1006,224,449,1001,223,1,223,8,677,226,224,1002,223,2,223,1005,224,464,101,1,223,223,1108,226,677,224,1002,223,2,223,1006,224,479,1001,223,1,223,1108,677,677,224,1002,223,2,223,1005,224,494,101,1,223,223,7,677,677,224,1002,223,2,223,1005,224,509,101,1,223,223,1007,677,677,224,1002,223,2,223,1005,224,524,101,1,223,223,7,677,226,224,1002,223,2,223,1005,224,539,101,1,223,223,1107,677,226,224,102,2,223,223,1006,224,554,101,1,223,223,107,226,677,224,1002,223,2,223,1005,224,569,101,1,223,223,107,226,226,224,1002,223,2,223,1005,224,584,101,1,223,223,1108,677,226,224,102,2,223,223,1006,224,599,1001,223,1,223,1008,677,677,224,102,2,223,223,1006,224,614,101,1,223,223,7,226,677,224,102,2,223,223,1005,224,629,101,1,223,223,1008,226,677,224,1002,223,2,223,1006,224,644,101,1,223,223,1007,226,226,224,1002,223,2,223,1005,224,659,1001,223,1,223,1008,226,226,224,102,2,223,223,1006,224,674,1001,223,1,223,4,223,99,226};

    private static int theInput = 42;

    public static void main(String[] args) {
        run(small0);
//        System.out.println(run(small1));
//        System.out.println(run(small2));

        // day 1
/*        int[] program = input.clone();
        program[1] = 12;
        program[2] =  2;
        run(program);
 */
     }

    private static void run(@NotNull int[] program) {
        int pointer = 0;
        while (true) {
            if (program[pointer] == end) {
                return;
            }
            Instruction inst = new Instruction(program, pointer);
            switch (inst.getOpcode()) {
                case 1:
                    program[inst.getOutPosition()] = inst.getParameterValue1() + inst.getParameterValue2();
                    break;
                case 2:
                    program[inst.getOutPosition()] = inst.getParameterValue1() * inst.getParameterValue2();
                    break;
                case 3:
                    program[inst.getOutPosition()] = theInput;
                    break;
                case 4:
                    System.out.println(inst.getParameterValue1());
                    break;
            }
            pointer += inst.getStep();
        }
    }


    private static class Instruction {
        private int[] program;
        private int opcode;
        private int step;

        private int parameterMode1 = 0;
        private int parameterMode2 = 0;
        private int parameterMode3 = 0;

        /** either a literal value or a position, depending on parameter mode being 0 or 1 */
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
                    step = 4;
                    parameterValue1 = program[position+1];
                    parameterValue2 = program[position+2];
                    outPosition = program[position+3];
                    break;
                case 3:
                    step = 2;
                    outPosition = program[position+1];
                    break;
                case 4:
                    step = 2;
                    parameterValue1 = program[position+1];
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
            if (instruction <= 99 ) {
                this.opcode = instruction;
                return;
            }

            String temp = instruction.toString();
            this.opcode = Integer.parseInt(temp.substring(temp.length() - 2));
            if (temp.length() > 2) {
                this.parameterMode1 = Integer.parseInt(temp.substring(temp.length() - 3), 1);
            }
            if (temp.length() > 3) {
                this.parameterMode2 = Integer.parseInt(temp.substring(temp.length() - 4), 1);
            }
            if (temp.length() > 4) {
                this.parameterMode3 = Integer.parseInt(temp.substring(temp.length() - 5), 1);
            }
        }

    }

}
