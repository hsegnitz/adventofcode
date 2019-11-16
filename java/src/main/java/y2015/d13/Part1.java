package y2015.d13;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Scanner;
import java.util.Set;

public class Part1 {

    private static String[] people;
    private static HashMap<String, Integer> happinessDeltas = new HashMap<>();
    private static int shortest = Integer.MAX_VALUE;
    private static int longest  = Integer.MIN_VALUE;

    public static void main(String[] args) {

        readFile();
    }

    public static void readFile() {

        File   file    = new File("src/main/java/y2015/d13/small.txt");
        String rawLine = "";
        HashMap<String, Boolean> localPeople = new HashMap<>();
        try {
            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                rawLine = scanner.nextLine();
                String[] split = rawLine.replaceAll("\\.", "").replaceAll("gain ", "").replaceAll("lose ", "-").split(" ");
                localPeople.put(split[0], true);
                localPeople.put(split[9], true);

                happinessDeltas.put(split[0] + ":" + split[9], Integer.parseInt(split[2]));
            }

            Set<String> keys = localPeople.keySet();
            people = keys.toArray(new String[0]);

            System.out.println(happinessDeltas);

        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

}
