package y2015.d12;

import java.io.File;
import java.util.Arrays;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {
        String input = readFile();

        input = input.replaceAll("[^-\\d]+", "x").replaceFirst("x", "").replaceAll("x$", "");

        int[] ints = Arrays.stream(input.split("x")).mapToInt(Integer::parseInt).toArray();

        int sum = 0;
        for (int value: ints) {
            sum += value;
        }

        System.out.println(sum);
    }

    public static String readFile() {

        File file = new File("src/main/java/y2015/d12/in.json");
        String rawLine = "";
        try {
            Scanner scanner = new Scanner(file);
            rawLine = scanner.nextLine();
            return rawLine;
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

        return "";
    }


}
