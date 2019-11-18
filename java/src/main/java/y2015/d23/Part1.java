package y2015.d23;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

public class Part1 {

    private static int a = 0;
    private static int b = 0;

    private static ArrayList<Instruction> program = new ArrayList<>();

    private static class Instruction {
        String name;
        String register;
        int offset;

        public Instruction(String name, String register, int offset) {
            this.name = name;
            this.register = register;
            this.offset = offset;
        }

        public Instruction(String name, int offset) {
            this.name = name;
            this.offset = offset;
        }

        public Instruction(String name, String register) {
            this.name = name;
            this.register = register;
        }

        public String getName() {
            return name;
        }

        public String getRegister() {
            return register;
        }

        public int getOffset() {
            return offset;
        }

        @Override
        public String toString() {
            return "Instruction{" +
                    "name='" + name + '\'' +
                    ", register='" + register + '\'' +
                    ", offset=" + offset +
                    '}';
        }
    }

    public static void main(String[] args) throws FileNotFoundException {

        readProgram();

    //    System.out.println(program);

        int pointer = 0;
        while (pointer >= 0 && pointer < program.size()) {
            Instruction instruction = program.get(pointer);
            switch (instruction.getName()) {
                case "hlf":
                    if (instruction.getRegister().equals("a")) {
                        a /= 2;
                    } else if (instruction.getRegister().equals("b")) {
                        b /= 2;
                    }
                    ++pointer;
                    break;
                case "tpl":
                    if (instruction.getRegister().equals("a")) {
                        a *= 3;
                    } else if (instruction.getRegister().equals("b")) {
                        b *= 3;
                    }
                    ++pointer;
                    break;
                case "inc":
                    if (instruction.getRegister().equals("a")) {
                        ++a;
                    } else if (instruction.getRegister().equals("b")) {
                        ++b;
                    }
                    ++pointer;
                    break;
                case "jmp":
                    pointer += instruction.getOffset();
                    break;
                case "jie":
                    if (instruction.getRegister().equals("a") && a % 2 == 0) {
                        pointer += instruction.getOffset();
                    } else if (instruction.getRegister().equals("b") && b % 2 == 0) {
                        pointer += instruction.getOffset();
                    } else {
                        ++pointer;
                    }
                    break;
                case "jio":
                    if (instruction.getRegister().equals("a") && a == 1) {
                        pointer += instruction.getOffset();
                    } else if (instruction.getRegister().equals("b") && b == 1) {
                        pointer += instruction.getOffset();
                    } else {
                        ++pointer;
                    }
                    break;
            }
        }

        System.out.println(b);
    }





    private static void readProgram() throws FileNotFoundException {
        File file = new File("src/main/java/y2015/d23/in.txt");
        Scanner scanner = new Scanner(file);

        String rawLine = "";
        while (scanner.hasNextLine()) {
            rawLine = scanner.nextLine();
            String[] split = rawLine.replaceAll(",", "").split(" ");
            if (split.length == 3) {
                program.add(new Instruction(split[0], split[1], Integer.parseInt(split[2])));
            } else if (split.length == 2) {
                if (split[1].matches("^[-+]\\d+$")) {
                    program.add(new Instruction(split[0], Integer.parseInt(split[1])));
                    continue;
                }
                program.add(new Instruction(split[0], split[1]));
            }
        }
    }

}
