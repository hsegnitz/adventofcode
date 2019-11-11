package y2015.d09;

import java.io.File;
import java.util.*;

public class Part1 {

    private static String[] cities;
    private static HashMap<String, Integer> distances = new HashMap<>();

    public static void main(String[] args) {

        readFile();

        System.out.println(cities);
        System.out.println(distances);

    }

    public static void readFile() {

        File file = new File("src/main/java/y2015/d09/small.txt");
        String rawLine   = "";
        HashMap<String, Boolean> localCities = new HashMap<>();
        try {
            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                rawLine = scanner.nextLine();
                String[] split = rawLine.split(" ");
                localCities.put(split[0], true);
                localCities.put(split[2], true);

                distances.put(split[0] + ":" + split[2], Integer.parseInt(split[4]));
                distances.put(split[2] + ":" + split[0], Integer.parseInt(split[4]));
            }

            Set<String> keys = localCities.keySet();
            cities = keys.toArray(new String[0]);
        } catch (Exception e) {
            System.out.println(e.getMessage());
            return;
        }

    }

}
