package y2015.d07;

import java.io.File;
import java.util.ArrayList;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {

        Wires wires = new Wires();
        ArrayList<Gate> gates = new ArrayList<Gate>();

        File file = new File("src/main/java/y2015/d07/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            String line = "";
            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                gates.add(new Gate(line));
            }
        } catch (Exception e) {
            System.out.println(e.getMessage());
            return;
        }

        while (!wires.hasWire("a")) {
            for (Gate gate: gates) {
                try {
                    gate.compute(wires);
                } catch (Exception e) {
                    System.out.println(e.getMessage());
                    return;
                }
            }

          //  wires.printWires();
          //  System.out.println("");
            // #return;
        }

        outputWithBitShift(wires.readWire("a"));
    }

    public static void outputWithBitShift(Short input) {
        int input2 = (int)input;
        if (input < 0) {
            input2 = (input & 0xFFFF);
        }

        System.out.println(input2);
    }

}
