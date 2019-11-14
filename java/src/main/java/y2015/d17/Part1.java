package y2015.d17;

import java.util.HashMap;
import java.util.Map;

public class Part1 {

    private static int target = 25;
    private static int count  =  0;

    public static void main(String[] args) {



    }

    public static void calc(HashMap<Integer, Integer> previous, Integer depth) {
        int sum = 0;
        for (Map.Entry<Integer, Integer> entry: previous.entrySet()) {
            sum += entry.getValue();
        }

        if (sum == target) {
            count++;
            return;
        }

        if (sum > target) {
            return;
        }

        HashMap<Integer, Integer> clone = (HashMap<Integer, Integer>) previous.clone();
        calc(clone, depth + 1);

        HashMap<Integer, Integer> containers = small();
        for (int i = depth; i < containers.size(); i++ ) {
            clone = (HashMap<Integer, Integer>) previous.clone();
            clone.put()
            calc(clone, depth + 1);
        }
        // iterate over the remainder of the choices --> skipping "depth" steps.
        // and recurse the cursed recursion!
        // also send forth an option that skips the position entirely!!!111oneeleven
        // that means we might traverse the whole thing from the right.


    }


    private static HashMap<Integer, Integer> small() {
        HashMap<Integer, Integer> map = new HashMap<>();
        map.put(0, 20);
        map.put(1, 15);
        map.put(2, 10);
        map.put(3,  5);
        map.put(4,  5);

        return map;
    }


}
