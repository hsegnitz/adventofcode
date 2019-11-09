package y2015.d02;

import java.io.File;
import java.io.FileReader;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d02/in.txt");
        try {
            int squareFoot = 0;
            int ribbon = 0;
            Scanner scanner = new Scanner(file);
            String line = "";
            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                String[] split = line.split("x");

                Gift gift = new Gift(
                        Integer.parseInt(split[0]),
                        Integer.parseInt(split[1]),
                        Integer.parseInt(split[2])
                );

                ribbon += gift.getRibbon();
                squareFoot += gift.getTotalWrappingPaper();
            }

            System.out.println("Total Square Footage: " + squareFoot);
            System.out.println("Total Ribbon Length: " + ribbon);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
