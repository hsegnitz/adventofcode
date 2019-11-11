package y2015.d09;

import java.io.File;
import java.util.*;

public class Part1 {

    private static String[] cities;
    private static HashMap<String, Integer> distances = new HashMap<>();

    public static void main(String[] args) {

        readFile();
        int shortest = Integer.MAX_VALUE;

        // nested loops - one per city
        for (int a = 0; a < cities.length; a++) {
            ArrayList<String> pathA = new ArrayList<>();
            pathA.add(cities[a]);
            for (int b = 0; b < cities.length; b++) {
                ArrayList<String> pathB = (ArrayList<String>) pathA.clone();
                if (pathB.contains(cities[b])) {
                    continue;
                }
                pathB.add(cities[b]);
                for (int c = 0; c < cities.length; c++) {
                    ArrayList<String> pathC = (ArrayList<String>) pathB.clone();
                    if (pathC.contains(cities[c])) {
                        continue;
                    }
                    pathC.add(cities[c]);

                    System.out.println(pathC);
                }
            }
        }

        // calculate length of path as a function
        // if short as previous one, store length as "shortest"
    }

    public static int calculatePathLength(ArrayList<String> path) {
        
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
