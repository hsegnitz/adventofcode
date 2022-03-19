package y2019.d03;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;

public class Part2 {

    private static class Direction {
        private char direction;
        private Integer length;

        public Direction(String raw) {
            this.direction = raw.charAt(0);
            this.length = Integer.parseInt(raw.substring(1));
        }

        public char getDirection() {
            return direction;
        }

        public Integer getLength() {
            return length;
        }
    }

    private static HashMap<String, Integer> wireA = new HashMap<>();

    private static int nearest = Integer.MAX_VALUE;

    public static void main(String[] args) throws FileNotFoundException {

        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d03/in.txt");
        ArrayList<Direction> wireADirections = parseWire(input.get(0));
        ArrayList<Direction> wireBDirections = parseWire(input.get(1));

        // for the first wire create entries in "wireA" hash set with the coordinates
        int x = 0;
        int y = 0;
        int steps = 0;
        for (Direction a: wireADirections) {
            if (a.getDirection() == 'R') {
                for (int i = 0; i < a.getLength(); i++) {
                    wireA.putIfAbsent("" + ++x + "x" + y, ++steps);
                }
            }
            if (a.getDirection() == 'L') {
                for (int i = 0; i < a.getLength(); i++) {
                    wireA.putIfAbsent("" + --x + "x" + y, ++steps);
                }
            }
            if (a.getDirection() == 'U') {
                for (int i = 0; i < a.getLength(); i++) {
                    wireA.putIfAbsent("" + x + "x" + ++y, ++steps);
                }
            }
            if (a.getDirection() == 'D') {
                for (int i = 0; i < a.getLength(); i++) {
                    wireA.putIfAbsent("" + x + "x" + --y, ++steps);
                }
            }
        }

        // then walk along the second wire and whenever we find the coordinate in the map, calc the distance
        x = 0;
        y = 0;
        steps = 0;
        for (Direction b: wireBDirections) {
            if (b.getDirection() == 'R') {
                for (int i = 0; i < b.getLength(); i++) {
                    String key = "" + ++x + "x" + y;
                    steps++;
                    if (wireA.containsKey(key)) {
                        nearest = Math.min(nearest, wireA.get(key) + steps);
                    }
                }
            }
            if (b.getDirection() == 'L') {
                for (int i = 0; i < b.getLength(); i++) {
                    String key = "" + --x + "x" + y;
                    steps++;
                    if (wireA.containsKey(key)) {
                        nearest = Math.min(nearest, wireA.get(key) + steps);
                    }
                }
            }
            if (b.getDirection() == 'U') {
                for (int i = 0; i < b.getLength(); i++) {
                    String key = "" + x + "x" + ++y;
                    steps++;
                    if (wireA.containsKey(key)) {
                        nearest = Math.min(nearest, wireA.get(key) + steps);
                    }
                }
            }
            if (b.getDirection() == 'D') {
                for (int i = 0; i < b.getLength(); i++) {
                    String key = "" + x + "x" + --y;
                    steps++;
                    if (wireA.containsKey(key)) {
                        nearest = Math.min(nearest, wireA.get(key) + steps);
                    }
                }
            }
        }

        System.out.println(nearest);



    }

    private static ArrayList<Direction> parseWire(String input) {
        ArrayList<Direction> wire = new ArrayList<Direction>();
        for (String command: input.split(",")) {
            wire.add(new Direction(command));
        }
        return wire;
    }

}
