package y2016.d06;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<HashMap<String, Integer>> columns = new ArrayList<HashMap<String, Integer>>();

        for (int i = 0; i < 8; i++) {
            columns.add(new HashMap<String, Integer>());
        }

        ArrayList<String> lines = Files.readByLines("src/main/java/y2016/d06/in.txt");

        for (String s: lines) {
            for (int i = 0; i < s.length(); i++) {
                String l = s.substring(i, i+1);
                if (!columns.get(i).containsKey(l)) {
                    columns.get(i).put(l, 1);
                } else {
                    columns.get(i).put(l, columns.get(i).get(l) + 1);
                }
            }
        }

        for (HashMap<String, Integer> col: columns) {
            int largest = 0;
            for (Map.Entry<String, Integer> set: col.entrySet()) {
                largest  = Math.max(set.getValue(), largest);
            }
            for (Map.Entry<String, Integer> set: col.entrySet()) {
                if (set.getValue() == largest) {
                    System.out.print(set.getKey());
                }
            }
            System.out.println("");
        }
        System.out.println("");

        for (HashMap<String, Integer> col: columns) {
            int smallest = Integer.MAX_VALUE;
            for (Map.Entry<String, Integer> set: col.entrySet()) {
                smallest = Math.min(set.getValue(), smallest);
            }

            for (Map.Entry<String, Integer> set: col.entrySet()) {
                if (set.getValue() == smallest) {
                    System.out.print(set.getKey());
                }
            }
            System.out.println("");
        }
    }
}
