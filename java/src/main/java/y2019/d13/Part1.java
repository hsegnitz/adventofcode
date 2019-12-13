package y2019.d13;

import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.LinkedList;

public class Part1 {
    private static final long end = 99;

    private static final long[] input  = {1,380,379,385,1008,2617,649812,381,1005,381,12,99,109,2618,1101,0,0,383,1102,1,0,382,21001,382,0,1,21002,383,1,2,21102,37,1,0,1106,0,578,4,382,4,383,204,1,1001,382,1,382,1007,382,43,381,1005,381,22,1001,383,1,383,1007,383,23,381,1005,381,18,1006,385,69,99,104,-1,104,0,4,386,3,384,1007,384,0,381,1005,381,94,107,0,384,381,1005,381,108,1105,1,161,107,1,392,381,1006,381,161,1101,-1,0,384,1105,1,119,1007,392,41,381,1006,381,161,1101,0,1,384,21001,392,0,1,21101,0,21,2,21102,0,1,3,21102,1,138,0,1106,0,549,1,392,384,392,21001,392,0,1,21102,21,1,2,21102,1,3,3,21102,161,1,0,1105,1,549,1101,0,0,384,20001,388,390,1,20101,0,389,2,21102,1,180,0,1106,0,578,1206,1,213,1208,1,2,381,1006,381,205,20001,388,390,1,20101,0,389,2,21102,205,1,0,1105,1,393,1002,390,-1,390,1102,1,1,384,21002,388,1,1,20001,389,391,2,21101,228,0,0,1105,1,578,1206,1,261,1208,1,2,381,1006,381,253,20102,1,388,1,20001,389,391,2,21102,1,253,0,1105,1,393,1002,391,-1,391,1101,0,1,384,1005,384,161,20001,388,390,1,20001,389,391,2,21101,0,279,0,1106,0,578,1206,1,316,1208,1,2,381,1006,381,304,20001,388,390,1,20001,389,391,2,21101,304,0,0,1106,0,393,1002,390,-1,390,1002,391,-1,391,1101,0,1,384,1005,384,161,20102,1,388,1,21002,389,1,2,21102,0,1,3,21101,0,338,0,1105,1,549,1,388,390,388,1,389,391,389,21002,388,1,1,20102,1,389,2,21102,4,1,3,21101,0,365,0,1106,0,549,1007,389,22,381,1005,381,75,104,-1,104,0,104,0,99,0,1,0,0,0,0,0,0,361,19,18,1,1,21,109,3,21201,-2,0,1,22101,0,-1,2,21101,0,0,3,21101,0,414,0,1106,0,549,21201,-2,0,1,22102,1,-1,2,21102,429,1,0,1105,1,601,2102,1,1,435,1,386,0,386,104,-1,104,0,4,386,1001,387,-1,387,1005,387,451,99,109,-3,2106,0,0,109,8,22202,-7,-6,-3,22201,-3,-5,-3,21202,-4,64,-2,2207,-3,-2,381,1005,381,492,21202,-2,-1,-1,22201,-3,-1,-3,2207,-3,-2,381,1006,381,481,21202,-4,8,-2,2207,-3,-2,381,1005,381,518,21202,-2,-1,-1,22201,-3,-1,-3,2207,-3,-2,381,1006,381,507,2207,-3,-4,381,1005,381,540,21202,-4,-1,-1,22201,-3,-1,-3,2207,-3,-4,381,1006,381,529,21202,-3,1,-7,109,-8,2105,1,0,109,4,1202,-2,43,566,201,-3,566,566,101,639,566,566,1202,-1,1,0,204,-3,204,-2,204,-1,109,-4,2106,0,0,109,3,1202,-1,43,593,201,-2,593,593,101,639,593,593,21002,0,1,-2,109,-3,2106,0,0,109,3,22102,23,-2,1,22201,1,-1,1,21101,0,499,2,21101,0,275,3,21101,0,989,4,21101,630,0,0,1105,1,456,21201,1,1628,-2,109,-3,2105,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,2,2,2,0,2,2,2,2,2,2,0,2,2,0,2,2,2,2,2,0,2,0,2,2,0,0,0,0,2,2,2,2,2,0,0,0,2,2,0,1,1,0,0,0,0,0,0,2,0,2,0,2,2,0,2,0,0,2,0,2,2,2,0,2,2,2,2,0,2,0,2,2,2,2,2,0,2,0,2,2,2,0,1,1,0,2,0,2,0,0,2,2,0,2,0,2,2,2,2,2,0,2,0,0,2,2,2,2,2,2,2,2,2,0,0,0,0,2,0,2,2,2,2,2,0,1,1,0,2,2,2,2,2,0,2,2,2,2,2,0,2,2,2,2,2,2,0,0,0,0,2,2,0,0,0,2,2,2,0,0,0,0,2,0,0,2,0,0,1,1,0,2,2,2,2,0,0,2,2,2,2,2,2,2,0,0,0,0,2,0,2,2,2,2,0,0,2,0,0,2,0,0,2,2,2,2,0,0,2,2,0,1,1,0,2,2,2,0,2,2,0,0,2,2,0,2,2,2,0,0,2,0,2,2,0,2,0,2,2,2,2,2,2,0,2,2,2,2,2,2,0,2,2,0,1,1,0,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,0,2,2,0,0,0,2,2,2,2,0,2,2,2,2,0,2,2,2,2,2,2,0,1,1,0,0,0,0,2,0,2,2,0,2,2,2,0,0,0,2,0,0,2,0,2,0,2,2,2,0,2,0,2,2,2,2,2,2,0,2,2,0,2,0,0,1,1,0,2,2,2,2,2,0,2,0,0,2,0,2,2,0,2,0,2,2,2,0,2,2,2,0,2,0,0,2,0,2,2,0,2,0,2,0,2,2,2,0,1,1,0,2,2,2,0,0,2,2,2,2,0,2,0,0,0,2,0,0,2,2,2,0,0,2,0,2,0,2,2,2,2,0,2,0,2,0,2,0,0,2,0,1,1,0,2,2,2,2,2,0,0,2,2,0,0,0,2,0,2,0,2,0,0,2,0,0,2,2,2,2,2,2,2,2,2,2,2,0,2,2,2,2,2,0,1,1,0,2,2,2,0,2,0,0,2,0,0,2,0,2,2,0,0,2,0,2,2,0,2,2,2,2,2,0,2,0,0,2,2,2,0,2,0,2,0,2,0,1,1,0,2,2,2,2,2,2,0,2,0,0,2,2,2,0,2,2,0,2,0,0,2,0,0,0,0,2,2,0,0,2,0,0,2,0,0,0,0,2,2,0,1,1,0,2,2,2,2,2,2,0,2,0,0,0,0,0,2,0,0,0,2,2,2,2,0,2,0,2,0,0,0,0,2,0,0,2,2,2,0,0,0,2,0,1,1,0,0,2,0,0,2,0,2,0,2,2,2,0,2,0,2,0,2,2,2,0,0,2,2,0,2,0,0,0,2,2,2,0,0,0,2,2,2,2,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,50,83,69,55,5,36,88,27,48,45,55,26,23,56,75,93,20,97,93,90,50,24,84,49,93,23,74,88,42,37,31,74,42,93,56,81,50,48,64,26,80,53,72,51,63,25,30,74,85,93,5,1,78,10,85,22,20,18,92,98,97,29,52,22,67,48,79,50,19,64,11,1,29,71,44,32,19,30,36,73,78,28,13,42,33,74,56,38,1,55,94,9,53,16,26,24,75,3,17,67,18,19,7,56,61,22,71,85,2,24,80,20,6,33,12,67,38,81,41,59,81,38,17,7,61,10,77,36,96,85,10,71,76,68,90,62,93,16,83,61,59,42,83,81,10,94,35,38,66,27,61,26,61,61,65,1,42,65,83,30,23,96,39,87,30,38,47,97,48,77,38,23,23,26,36,58,77,33,44,23,21,49,72,7,46,73,43,86,8,71,92,43,16,1,72,40,55,10,74,5,84,24,92,24,10,47,7,49,9,23,6,80,18,78,88,50,31,56,45,35,74,62,68,74,45,78,5,20,75,83,72,13,59,66,76,63,49,97,54,9,16,32,39,7,45,16,32,57,71,18,80,90,54,8,27,53,5,10,2,74,79,34,2,76,21,80,75,62,88,46,32,26,5,1,60,14,73,60,7,69,93,36,4,63,94,89,2,55,30,5,7,28,71,72,45,44,3,98,43,42,28,63,69,52,61,67,79,80,55,1,39,1,58,6,82,64,81,11,16,41,50,23,31,94,98,75,96,94,40,98,97,20,88,94,64,17,61,60,63,26,76,87,73,80,30,15,61,90,61,16,41,86,52,67,90,58,85,33,29,59,92,45,10,82,22,65,62,43,14,92,47,17,25,15,55,55,25,70,52,63,86,73,86,34,43,7,2,94,93,13,73,28,88,23,12,82,16,79,56,36,32,52,62,82,81,57,39,88,70,25,50,14,80,52,56,11,81,14,15,83,36,84,76,74,21,19,56,1,29,44,68,87,42,68,92,54,13,76,48,48,66,89,49,64,32,59,53,30,57,20,94,72,42,2,77,7,56,54,27,17,67,67,56,94,8,58,28,81,9,72,64,20,95,92,7,61,7,46,44,2,81,17,78,7,32,64,40,17,47,62,57,19,61,36,88,10,71,6,88,39,43,48,2,50,30,20,39,75,9,46,78,17,56,88,96,20,50,7,14,12,67,7,23,77,94,58,44,96,65,48,44,60,52,65,88,39,45,13,63,37,16,2,26,41,95,73,45,37,29,35,82,30,14,90,18,29,33,92,23,63,51,79,17,86,76,83,85,20,43,48,51,28,94,50,77,74,90,5,33,52,47,14,76,70,3,59,28,95,78,82,1,6,59,97,38,68,60,68,95,31,98,8,32,71,70,25,47,76,75,13,35,60,19,45,7,49,34,61,93,21,79,81,52,17,82,28,69,35,72,10,12,55,25,45,9,67,60,67,27,97,26,13,30,4,6,64,34,36,88,19,90,50,35,32,6,38,15,18,88,10,42,68,71,31,29,45,90,50,85,13,69,80,91,4,21,81,18,21,38,44,42,49,54,47,61,43,17,54,89,47,13,27,6,67,96,54,80,54,85,32,1,39,18,28,98,55,30,2,90,43,9,48,43,54,42,21,3,50,49,2,47,23,51,2,66,88,80,24,66,31,28,68,15,93,34,55,69,86,92,16,13,69,26,78,20,84,16,87,1,51,91,65,89,70,31,28,48,28,81,54,40,81,77,25,64,98,41,46,30,50,9,33,58,24,31,62,41,92,4,40,12,53,32,50,62,78,80,36,90,36,47,9,34,13,91,36,74,82,60,31,74,77,33,16,79,10,68,56,52,43,71,76,31,65,14,68,49,73,36,55,76,48,37,3,33,85,8,42,92,44,66,22,84,54,98,50,8,21,70,63,89,53,21,20,72,9,46,38,27,20,76,66,57,15,73,23,34,36,38,46,53,76,86,45,75,50,27,25,81,80,68,95,73,12,89,58,15,30,79,63,35,62,53,15,27,64,89,21,58,65,80,16,92,64,29,89,16,71,23,68,46,30,17,41,67,4,16,84,25,9,78,46,18,85,3,26,32,12,45,49,79,11,4,65,82,17,21,29,60,1,20,16,93,72,7,17,88,67,75,3,24,73,73,71,54,35,95,57,80,16,7,44,8,58,83,68,87,21,41,90,7,85,32,22,41,23,47,30,56,94,27,50,65,62,36,74,51,39,21,36,44,47,96,15,59,72,97,84,25,649812};



    public static void main(String[] args) {
        IntCodeProgram program = new IntCodeProgram(input);

        ArrayList<Long> output = outputAsList(program);

        long maxX = 0;
        long maxY = 0;

        int count = 0;
        for (int i = 0; i < output.size()-1; i += 3) {
            long x = output.get(i);
            long y = output.get(i+1);

            maxX = Math.max(maxX, x);
            maxY = Math.max(maxY, y);

            long t = output.get(i+2);
            if (t == 2L) {
                ++count;
            }
        }
        System.out.println(count);
        System.out.println(maxX);
        System.out.println(maxY);

    }

    private static ArrayList<Long> outputAsList(IntCodeProgram program) {
        ArrayList<Long> out = new ArrayList<>();
        long output = 0;
        while (output != -1) {
            output = program.run();
            out.add(output);
        }
        return out;
    }

    private static class Tile {
        long x    = -1;
        long y    = -1;
        long type = -1;

        public Tile(long x, long y, long type) {
            this.x = x;
            this.y = y;
            this.type = type;
        }

        public long getX() {
            return x;
        }

        public long getY() {
            return y;
        }

        public long getType() {
            return type;
        }
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
            if (parameterMode1 == 2) {
                return this.program.get(parameterValue1+offset);
            }
            return this.program.get(parameterValue1);
        }

        public long getParameterValue2(long offset) {
            if (parameterMode2 == 1) {
                return parameterValue2;
            }
            if (parameterMode2 == 2) {
                return this.program.get(parameterValue2+offset);
            }
            return this.program.get(parameterValue2);
        }

        public long getParameterValue3(long offset) {
            if (parameterMode3 == 1) {
                return parameterValue3;
            }
            if (parameterMode3 == 2) {
                return this.program.get(parameterValue3+offset);
            }
            return this.program.get(parameterValue3);
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
