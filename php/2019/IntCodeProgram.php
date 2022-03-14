<?php

class IntCodeProgram {

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
