package y2015.d05;

import y2015.d02.Gift;

import java.io.File;
import java.util.Scanner;

public class Part1 {

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
        return hasThreeVowels(input) && hasDoubleLetter(input) && hasNotCertainCombinations(input);
    }

    public static boolean hasThreeVowels(String input) {
        int count = 0;

        for (final char letter: input.toCharArray()) {
            switch (letter) {
                case 'a':
                case 'e':
                case 'i':
                case 'o':
                case 'u':
                    ++count;
                    break;
            }
            if (count == 3) {
                return true;
            }
        }

        return false;
    }

    public static boolean hasDoubleLetter(String input) {

        char previous = ' ';
        for (final char letter: input.toCharArray()) {
            if (letter == previous) {
                return true;
            }
            previous = letter;
        }

        return false;
    }

    public static boolean hasNotCertainCombinations(String input) {

        char previous = ' ';
        String check = "  ";
        for (final char letter: input.toCharArray()) {
            check = Character.toString(previous) + Character.toString(letter);

            switch (check) {
                case "ab":
                case "cd":
                case "pq":
                case "xy":
                    return false;
            }

            previous = letter;
        }

        return true;
    }

}
