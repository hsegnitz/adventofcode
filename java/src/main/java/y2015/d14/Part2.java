package y2015.d14;

import java.util.Collections;
import java.util.HashMap;
import java.util.Map;

public class Part2 {

    public static void main(String[] args) {
        Reindeer[] reindeers = ReindeerFactory.getReindeers();

        HashMap<String, Integer> scores = new HashMap<>();

        for (Reindeer deer: reindeers) {
            scores.put(deer.getName(), 0);
        }


        for (int i = 1; i <= 2504; i++) {
            scores = pointToReindeerOfTheSecond(reindeers, scores, i);
        }

        System.out.println(scores);
    }

    public static HashMap<String, Integer> pointToReindeerOfTheSecond(Reindeer[] reindeers, HashMap<String, Integer>scores, int second) {
        HashMap<Reindeer, Integer> positions = new HashMap<>();
        for (Reindeer deer: reindeers) {
            positions.put(deer, deer.kilometersAfter(second));
        }

        int max = Collections.max(positions.entrySet(), Map.Entry.comparingByValue()).getKey().kilometersAfter(second);

        for (Reindeer deer: reindeers) {
            if (deer.kilometersAfter(second) == max) {
                scores.put(deer.getName(), scores.get(deer.getName())+1);
            }
        }

        return scores;
    }

}
