package y2019.d11;

import y2015.d06.Instruction;

import java.util.HashSet;
import java.util.LinkedHashMap;
import java.util.LinkedList;
import java.util.Set;

public class Part1 {
    private static final long end = 99;

    private static final long[] input = {3,8,1005,8,330,1106,0,11,0,0,0,104,1,104,0,3,8,102,-1,8,10,101,1,10,10,4,10,1008,8,0,10,4,10,102,1,8,29,2,9,4,10,1006,0,10,1,1103,17,10,3,8,102,-1,8,10,101,1,10,10,4,10,108,0,8,10,4,10,101,0,8,61,1006,0,21,1006,0,51,3,8,1002,8,-1,10,101,1,10,10,4,10,108,1,8,10,4,10,1001,8,0,89,1,102,19,10,1,1107,17,10,1006,0,18,3,8,1002,8,-1,10,1001,10,1,10,4,10,1008,8,1,10,4,10,1001,8,0,123,1,9,2,10,2,1105,10,10,2,103,9,10,2,1105,15,10,3,8,102,-1,8,10,1001,10,1,10,4,10,1008,8,0,10,4,10,102,1,8,161,3,8,102,-1,8,10,101,1,10,10,4,10,108,1,8,10,4,10,101,0,8,182,3,8,1002,8,-1,10,101,1,10,10,4,10,1008,8,0,10,4,10,101,0,8,205,2,1102,6,10,1006,0,38,2,1007,20,10,2,1105,17,10,3,8,102,-1,8,10,1001,10,1,10,4,10,108,1,8,10,4,10,1001,8,0,241,3,8,102,-1,8,10,101,1,10,10,4,10,108,1,8,10,4,10,101,0,8,263,1006,0,93,2,5,2,10,2,6,7,10,3,8,102,-1,8,10,101,1,10,10,4,10,108,0,8,10,4,10,1001,8,0,296,1006,0,81,1006,0,68,1006,0,76,2,4,4,10,101,1,9,9,1007,9,1010,10,1005,10,15,99,109,652,104,0,104,1,21102,825594262284L,1,1,21102,347,1,0,1105,1,451,21101,0,932855939852L,1,21101,358,0,0,1106,0,451,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,21102,1,235152649255L,1,21101,405,0,0,1105,1,451,21102,235350879235L,1,1,21102,416,1,0,1106,0,451,3,10,104,0,104,0,3,10,104,0,104,0,21102,988757512972L,1,1,21101,439,0,0,1106,0,451,21102,1,988669698828L,1,21101,0,450,0,1106,0,451,99,109,2,22101,0,-1,1,21102,40,1,2,21102,1,482,3,21102,472,1,0,1106,0,515,109,-2,2105,1,0,0,1,0,0,1,109,2,3,10,204,-1,1001,477,478,493,4,0,1001,477,1,477,108,4,477,10,1006,10,509,1101,0,0,477,109,-2,2106,0,0,0,109,4,1202,-1,1,514,1207,-3,0,10,1006,10,532,21102,1,0,-3,21202,-3,1,1,21202,-2,1,2,21102,1,1,3,21102,1,551,0,1106,0,556,109,-4,2105,1,0,109,5,1207,-3,1,10,1006,10,579,2207,-4,-2,10,1006,10,579,22101,0,-4,-4,1105,1,647,21201,-4,0,1,21201,-3,-1,2,21202,-2,2,3,21102,598,1,0,1105,1,556,21202,1,1,-4,21101,0,1,-1,2207,-4,-2,10,1006,10,617,21102,1,0,-1,22202,-2,-1,-2,2107,0,-3,10,1006,10,639,21202,-1,1,1,21102,1,639,0,105,1,514,21202,-2,-1,-2,22201,-4,-2,-4,109,-5,2105,1,0};

    private static long[][] field = new long[200][200];

    private static Set<String> seen = new HashSet<>();


    public static void main(String[] args) throws Exception {

        for (int a = 0; a < 200; a++) {
            for (int b = 0; b < 200; b++) {
                field[a][b] = 0L;
            }
        }

        IntCodeProgram program = new IntCodeProgram(input);

        int posX = 100;
        int posY = 100;

        Directions heading = Directions.NORTH;

        long output = 0;
        while (output != -1) {
            program.addInput(field[posY][posX]);

            output = program.run();
            if (output < 0) {
                continue;
            }

            field[posY][posX] = output;

            output = program.run();
            if (output < 0) {
                continue;
            }


            storePosition(posX, posY);
            heading = turn(output, heading);
            switch (heading) {
                case NORTH: posY++; break;
                case EAST:  posX++; break;
                case SOUTH: posY--; break;
                case WEST:  posX--; break;
            }
        }

        System.out.println(seen.size());
    }

    private static void storePosition(int posX, int posY) {
        String pos = "" + posX + ":" + posY;
        System.out.println(pos);
        seen.add(pos);
    }



    private static Directions turn(long command, Directions current) throws Exception {
        if (1L == command) {
            switch (current) {
                case NORTH: return Directions.EAST;
                case EAST:  return Directions.SOUTH;
                case SOUTH: return Directions.WEST;
                case WEST:  return Directions.NORTH;
            }
        }
        switch (current) {
            case NORTH: return Directions.WEST;
            case EAST:  return Directions.NORTH;
            case SOUTH: return Directions.EAST;
            case WEST:  return Directions.SOUTH;
        }
        throw new Exception("Whaaaaaaaaa....???!!!!");
    }



    private enum Directions {
        NORTH, EAST, SOUTH, WEST
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
            if (posi >= this.program.size()) {
                return 0L;
            }
            return this.program.get(posi);
        }

        public long getParameterValue2(long offset) {
            if (parameterMode2 == 1) {
                return parameterValue2;
            }

            long posi = parameterValue2;
            if (parameterMode2 == 2) {
                posi += offset;
            }
            if (posi >= this.program.size()) {
                return 0L;
            }
            return this.program.get(posi);
        }

        public long getParameterValue3(long offset) {
            if (parameterMode3 == 1) {
                return parameterValue3;
            }

            long posi = parameterValue3;
            if (parameterMode3 == 2) {
                posi += offset;
            }
            if (posi >= this.program.size()) {
                return 0L;
            }
            return this.program.get(posi);
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
