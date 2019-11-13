package y2015.d14;

import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.Map;

public class Part1 {

    public static void main(String[] args) {
        Reindeer[] reindeers = ReindeerFactory.getReindeers();

        HashMap<Reindeer, Integer> scores = new HashMap<>();

        for (Reindeer deer: reindeers) {
            scores.put(deer, deer.kilometersAfter(2503));
        }

        Reindeer farthest = Collections.max(scores.entrySet(), Map.Entry.comparingByValue()).getKey();

        System.out.println(farthest.getName() + ": " + farthest.kilometersAfter(2503));
    }

}
