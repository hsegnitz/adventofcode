package y2017.d02;

import java.io.File;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2017/d02/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            String line = "";
            int checksum = 0;
            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                String[] split = line.split("\t");
                int largest  = Integer.MIN_VALUE;
                int smallest = Integer.MAX_VALUE;

                for (String number: split) {
                    largest  = Math.max(Integer.parseInt(number), largest);
                    smallest = Math.min(Integer.parseInt(number), smallest);
                }

                checksum += largest - smallest;
            }

            System.out.println("Checksum: " + checksum);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
