package y2015.d05;

import java.io.File;
import java.util.Scanner;

public class Part2 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d05/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            String line = "";
            int total = 0;
            int nice = 0;
            while (scanner.hasNextLine()) {
                ++total;
                line = scanner.nextLine();
                if (isNice(line)) {
                    ++nice;
                }
            }

            System.out.println("Total Lines: " + total);
            System.out.println("Nice Lines: " + nice);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    private static boolean isNice(String input) {
        return hasDoubledTwoLetterSequence(input) && hasXYXSequence(input);
    }

    private static boolean hasDoubledTwoLetterSequence(String input) {
        return input.matches(".*([a-z]{2}).*\\1.*");
    }

    private static boolean hasXYXSequence(String input) {
        return input.matches(".*([a-z]).\\1.*");
    }
}
