package y2015.d09;

import java.io.File;
import java.util.*;

public class Part1 {

    private static String[] cities;
    private static HashMap<String, Integer> distances = new HashMap<>();
    private static int shortest = Integer.MAX_VALUE;

    public static void main(String[] args) {

        readFile();
        int shortest = Integer.MAX_VALUE;

        // nested loops - one per city
        for (int i = 0; i < cities.length; i++) {
            ArrayList<String> path = new ArrayList<>();
            path.add(cities[i]);
            addCity(path);
        }
    }

    public static int calculatePathLength(ArrayList<String> path) {
        int distance = 0;
        for (int i = 0; i < path.size()-1; i++) {
            distance += distances.get(path.get(i) + ":" + path.get(i+1));
        }
        return distance;
    }

    public static void addCity(ArrayList<String> path) {
        for (String city : cities) {
            ArrayList<String>pathB = (ArrayList<String>) path.clone();
            if (path.contains(city)) {
                continue;
            }
            pathB.add(city);
            if (pathB.size() == cities.length) {
                int distance = calculatePathLength(pathB);

                shortest = Math.min(shortest, distance);

                System.out.println(pathB + " -- [" + distance + "] -- shortest(" + shortest + ")");
            } else {
                addCity(pathB);
            }
        }
    }

    public static void readFile() {

        File file = new File("src/main/java/y2015/d09/in.txt");
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
        }
    }

}
