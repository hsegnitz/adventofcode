package y2015.d06;

import java.io.File;
import java.util.Scanner;

public class Part2 {
    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d06/in.txt");
        Grid2 grid = new Grid2();

        try {
            Scanner scanner = new Scanner(file);
            String line = "";
            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                Instruction instruction = new Instruction(line);
                grid.apply(instruction);
            }

            // System.out.println(grid);
            System.out.println("Total Brightness: " + grid.countBrightness());
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }


}
