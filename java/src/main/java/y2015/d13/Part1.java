package y2015.d13;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Scanner;
import java.util.Set;

public class Part1 {

    private static String[] people;
    private static HashMap<String, Integer> happinessDeltas = new HashMap<>();
    private static int highest = Integer.MIN_VALUE;

    public static void main(String[] args) {

        readFile();

        // nested loops - one per person
        ArrayList<String> order = new ArrayList<>();
        addPerson(order);
    }

    public static int calculateHappiness(ArrayList<String> order) {
        int happiness = 0;
        for (int i = 0; i < order.size()-1; i++) {
            happiness += happinessDeltas.get(order.get(i)   + ":" + order.get(i+1));
            happiness += happinessDeltas.get(order.get(i+1) + ":" + order.get(i));
        }
        happiness += happinessDeltas.get(order.get(0)              + ":" + order.get(order.size()-1));
        happiness += happinessDeltas.get(order.get(order.size()-1) + ":" + order.get(0));
        return happiness;
    }

    public static void addPerson(ArrayList<String> order) {
        for (String person : people) {
            ArrayList<String>orderB = (ArrayList<String>) order.clone();
            if (order.contains(person)) {
                continue;
            }
            orderB.add(person);
            if (orderB.size() == people.length) {
                int happiness = calculateHappiness(orderB);

                highest = Math.max(highest,  happiness);

                System.out.println(orderB + " -- [" + happiness + "] -- highest(" + highest + ")");
            } else {
                addPerson(orderB);
            }
        }
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
