package y2019.d19;

import java.util.LinkedHashMap;
import java.util.LinkedList;

public class Part1 {
    private static final long end = 99;

    private static final long[] input  = {109,424,203,1,21101,11,0,0,1105,1,282,21102,1,18,0,1106,0,259,1201,1,0,221,203,1,21101,0,31,0,1106,0,282,21101,0,38,0,1105,1,259,21002,23,1,2,21201,1,0,3,21101,0,1,1,21101,0,57,0,1106,0,303,2102,1,1,222,21002,221,1,3,20102,1,221,2,21102,259,1,1,21101,0,80,0,1105,1,225,21102,1,118,2,21102,91,1,0,1105,1,303,2102,1,1,223,21001,222,0,4,21102,259,1,3,21101,0,225,2,21101,225,0,1,21101,0,118,0,1105,1,225,20101,0,222,3,21102,1,72,2,21102,133,1,0,1106,0,303,21202,1,-1,1,22001,223,1,1,21102,1,148,0,1105,1,259,1201,1,0,223,20101,0,221,4,20101,0,222,3,21101,22,0,2,1001,132,-2,224,1002,224,2,224,1001,224,3,224,1002,132,-1,132,1,224,132,224,21001,224,1,1,21102,1,195,0,106,0,108,20207,1,223,2,20101,0,23,1,21102,-1,1,3,21102,214,1,0,1105,1,303,22101,1,1,1,204,1,99,0,0,0,0,109,5,1201,-4,0,249,22101,0,-3,1,22101,0,-2,2,22101,0,-1,3,21101,0,250,0,1105,1,225,21202,1,1,-4,109,-5,2105,1,0,109,3,22107,0,-2,-1,21202,-1,2,-1,21201,-1,-1,-1,22202,-1,-2,-2,109,-3,2106,0,0,109,3,21207,-2,0,-1,1206,-1,294,104,0,99,22102,1,-2,-2,109,-3,2105,1,0,109,5,22207,-3,-4,-1,1206,-1,346,22201,-4,-3,-4,21202,-3,-1,-1,22201,-4,-1,2,21202,2,-1,-1,22201,-4,-1,1,22101,0,-2,3,21101,0,343,0,1106,0,303,1105,1,415,22207,-2,-3,-1,1206,-1,387,22201,-3,-2,-3,21202,-2,-1,-1,22201,-3,-1,3,21202,3,-1,-1,22201,-3,-1,2,21202,-4,1,1,21101,384,0,0,1106,0,303,1106,0,415,21202,-4,-1,-4,22201,-4,-3,-4,22202,-3,-2,-2,22202,-2,-4,-4,22202,-3,-2,-3,21202,-4,-1,-2,22201,-3,-2,1,21201,1,0,-4,109,-5,2106,0,0};

    public static void main(String[] args) {

        int count = 0;
        for (long y = 0; y < 50; y++) {
            for (long x = 0; x < 50; x++) {
                IntCodeProgram program = new IntCodeProgram(input);
                program.addInput(x);
                program.addInput(y);

                long isAffected = program.run();
                if (isAffected == 1) {
                    count++;
                    System.out.print("#");
                } else {
                    System.out.print(" ");
                }
            }
            System.out.println();
        }

        System.out.println(count);
    }

    /**
     * An intersection is a field with a # that is surrounded by at least
     */
    private static int getAlignmentCode(char[][] map) {
        int alignment = 0;

        for (int line = 1; line < map.length-1; line++) {
            for (int col = 1; col < map[line].length-1; col++) {
                if (map[line-1][col] == '#'
                        && map[line][col-1] == '#'
                        && map[line][col] == '#'
                        && map[line][col+1] == '#'
                        && map[line+1][col] == '#'
                ) {
                    alignment += (line*col);
                }
            }
        }

        return alignment;
    }

    private static class IntCodeProgram {

        private LinkedHashMap<Long, Long> program = new LinkedHashMap<>();

        private LinkedList<Long> input = new LinkedList<>();

        private long pointer = 0L;

        private long relativeBaseOffset = 0L;

        public IntCodeProgram(long[] program) {
            long pos = 0L;
            for (long instruction: program) {
                this.program.put(pos++, instruction);
            }
        }

        public void addInput(long input) {
            this.input.addLast(input);
        }

        public long run() {
            while (true) {
                if (this.program.get(this.pointer) == end) {
                    return -1;
                }
                Instruction inst = new Instruction(this.program, this.pointer);
                switch (inst.getOpcode()) {
                    case 1:
                        this.program.put(inst.getOutPosition(relativeBaseOffset), inst.getParameterValue1(relativeBaseOffset) + inst.getParameterValue2(relativeBaseOffset));
                        this.pointer += inst.getStep();
                        break;
                    case 2:
                        this.program.put(inst.getOutPosition(relativeBaseOffset), inst.getParameterValue1(relativeBaseOffset) * inst.getParameterValue2(relativeBaseOffset));
                        this.pointer += inst.getStep();
                        break;
                    case 3:
                        long inp = this.input.removeFirst();
                        this.program.put(inst.getOutPosition(relativeBaseOffset), inp);
                        this.pointer += inst.getStep();
                        break;
                    case 4:
                        this.pointer += inst.getStep();
                        return inst.getParameterValue1(relativeBaseOffset);
                    case 5:
                        if (inst.getParameterValue1(relativeBaseOffset) != 0) {
                            this.pointer = inst.getParameterValue2(relativeBaseOffset);
                        } else {
                            this.pointer += inst.getStep();
                        }
                        break;
                    case 6:
                        if (inst.getParameterValue1(relativeBaseOffset) == 0) {
                            this.pointer = inst.getParameterValue2(relativeBaseOffset);
                        } else {
                            this.pointer += inst.getStep();
                        }
                        break;
                    case 7:
                        if (inst.getParameterValue1(relativeBaseOffset) < inst.getParameterValue2(relativeBaseOffset)) {
                            this.program.put(inst.getOutPosition(relativeBaseOffset), 1L);
                        } else {
                            this.program.put(inst.getOutPosition(relativeBaseOffset), 0L);
                        }
                        this.pointer += inst.getStep();
                        break;
                    case 8:
                        if (inst.getParameterValue1(relativeBaseOffset) == inst.getParameterValue2(relativeBaseOffset)) {
                            this.program.put(inst.getOutPosition(relativeBaseOffset), 1L);
                        } else {
                            this.program.put(inst.getOutPosition(relativeBaseOffset), 0L);
                        }
                        this.pointer += inst.getStep();
                        break;
                    case 9:
                        this.relativeBaseOffset += inst.getParameterValue1(relativeBaseOffset);
                        this.pointer += inst.getStep();
                        break;
                }
            }
        }
    }

    private static class Instruction {
        private LinkedHashMap<Long, Long> program;
        private int opcode;
        private Long step;

        private int parameterMode1   = 0;
        private int parameterMode2   = 0;
        private int parameterMode3   = 0;
        private int outParameterMode = 0;

        /**
         * either a literal value or a position, depending on parameter mode being 0 or 1
         */
        private Long parameterValue1;
        private Long parameterValue2;
        private Long parameterValue3;

        private Long outPosition;

        public Instruction(LinkedHashMap<Long, Long> program, Long position) {
            this.program = program;
            this.parseInstruction(program.get(position));
            switch (opcode) {
                case 1:
                case 2:
                case 7:
                case 8:
                    step = 4L;
                    parameterValue1 = program.get(position + 1);
                    parameterValue2 = program.get(position + 2);
                    outPosition = program.get(position + 3);
                    outParameterMode = parameterMode3;
                    break;
                case 3:
                    step = 2L;
                    outPosition = program.get(position + 1);
                    outParameterMode = parameterMode1;
                    break;
                case 4:
                case 9:
                    step = 2L;
                    parameterValue1 = program.get(position + 1);
                    break;
                case 5:
                case 6:
                    step = 3L;
                    parameterValue1 = program.get(position + 1);
                    parameterValue2 = program.get(position + 2);
                    outParameterMode = parameterMode2;
                    break;
            }
        }

        public int getOpcode() {
            return opcode;
        }

        public long getStep() {
            return step;
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

        private void parseInstruction(Long instruction) {
            if (instruction <= 99) {
                this.opcode = instruction.intValue();
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
