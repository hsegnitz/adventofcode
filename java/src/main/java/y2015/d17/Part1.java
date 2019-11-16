package y2015.d17;

import java.io.File;
import java.util.*;

public class Part1 {

    private static int target = 150;
    private static int count  =   0;
    private static HashSet<String> seen = new HashSet<>();
    private static LinkedHashMap<Integer, Integer> allContainers = new LinkedHashMap<>();

    public static void main(String[] args) {
        allContainers = in();

        calc(new LinkedHashMap<Integer, Integer>(), 0);

        System.out.println(count);
    }

    public static void calc(LinkedHashMap<Integer, Integer> previous, Integer depth) {
        int sum = 0;
        ArrayList<Integer> keyList = new ArrayList<>();
        for (Map.Entry<Integer, Integer> entry: previous.entrySet()) {
            keyList.add(entry.getKey());
            sum += entry.getValue();
        }

        if (sum == target) {
            keyList.sort(Comparator.comparingInt(o -> o));

            String key = Arrays.toString(keyList.toArray());

            if (!seen.contains(key)) {
                count++;
                seen.add(key);
                System.out.println(key);
            }
            return;
        }

        if (sum > target) {
            return;
        }

        if (depth >= allContainers.size()) {
            return;
        }

        LinkedHashMap<Integer, Integer> clone = (LinkedHashMap<Integer, Integer>) previous.clone();
        calc(clone, depth + 1);

        for (int i = depth; i < allContainers.size(); i++ ) {
            clone = (LinkedHashMap<Integer, Integer>) previous.clone();
            clone.put(i, allContainers.get(i));
            calc(clone, depth + 1);
        }
    }


    private static LinkedHashMap<Integer, Integer> small() {
        LinkedHashMap<Integer, Integer> map = new LinkedHashMap<>();
        map.put(0, 20);
        map.put(1, 15);
        map.put(2, 10);
        map.put(3,  5);
        map.put(4,  5);

        return map;
    }

    private static LinkedHashMap<Integer, Integer> in() {
        LinkedHashMap<Integer, Integer> map = new LinkedHashMap<>();
        int counter = 0;
        File file = new File("src/main/java/y2015/d17/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                map.put(counter++, scanner.nextInt());
                scanner.nextLine();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

/*
        System.out.println(map);
        System.exit(42);
*/

        return map;
    }

}
