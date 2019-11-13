package y2015.d14;

import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.Map;

public class Part1 {

    public static void main(String[] args) {
        Reindeer[] reindeers = new Reindeer[]{
                new Reindeer("Vixen",    8,  8,  53),
                new Reindeer("Blitzen", 13,  4,  49),
                new Reindeer("Rudolph", 20,  7, 132),
                new Reindeer("Cupid",   12,  4,  43),
                new Reindeer("Donner",   9,  5,  38),
                new Reindeer("Dasher",  10,  4,  37),
                new Reindeer("Comet",    3, 37,  76),
                new Reindeer("Prancer",  9, 12,  97),
                new Reindeer("Dancer",  37,  1,  36)
        };

        HashMap<Reindeer, Integer> scores = new HashMap<>();

        for (Reindeer deer: reindeers) {
            scores.put(deer, deer.kilometersAfter(2503));
        }

        Reindeer farthest = Collections.max(scores.entrySet(), Map.Entry.comparingByValue()).getKey();

        System.out.println(farthest.getName() + ": " + farthest.kilometersAfter(2503));
    }

}
