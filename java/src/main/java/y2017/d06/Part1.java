package y2017.d06;

import java.util.Arrays;
import java.util.Collections;
import java.util.HashSet;
import java.util.List;

public class Part1 {

    private static List<Integer> smallBanks = Arrays.asList(0,  2, 7, 0);
    private static List<Integer> bigBanks   = Arrays.asList(4, 10, 4, 1, 8, 4, 9, 14, 5, 1, 14, 15, 0, 15, 3, 5);
    private static HashSet<String> seen = new HashSet<>();

    public static void main(String[] args) {
        int max = Collections.max(smallBanks);
        int pos = smallBanks.indexOf(max);
    }

}
