package y2015.d17;

import java.util.*;

public class Part1 {

    private static int target = 25;
    private static int count  =  0;
    private static HashSet<String> seen = new HashSet<>();

    public static void main(String[] args) {
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

        LinkedHashMap<Integer, Integer> containers = small();
        if (depth >= containers.size()) {
            return;
        }

        LinkedHashMap<Integer, Integer> clone = (LinkedHashMap<Integer, Integer>) previous.clone();
        calc(clone, depth + 1);

        for (int i = depth; i < containers.size(); i++ ) {
            clone = (LinkedHashMap<Integer, Integer>) previous.clone();
            clone.put(i, containers.get(i));
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


}
