package y2016.d03;

import java.io.File;
import java.util.*;

public class Part2 {

    private static class Triangle {
        private int shortest;
        private int middle;
        private int longest;

        public Triangle(int[] sides) {
            this.assignValuesSorted(sides);
        }

        public Triangle(String[] sides) {
            int[] newSides = {
                    Integer.parseInt(sides[0]),
                    Integer.parseInt(sides[1]),
                    Integer.parseInt(sides[2]),
            };

            this.assignValuesSorted(newSides);
        }

        private void assignValuesSorted (int[] sides) {
            Arrays.sort(sides);
            this.shortest = sides[0];
            this.middle   = sides[1];
            this.longest  = sides[2];
        }

        public boolean couldBeTriangle() {
            return (this.shortest + this.middle) > this.longest;
        }
    }

    public static void main(String[] args) {

        File file = new File("src/main/java/y2016/d03/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            String line = "";

            List<Integer> values = new LinkedList<>();

            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                String[] split = line.trim().split("\\s+");
                for (String s: split) {
                    values.add(Integer.parseInt(s));
                }
            }

            // iterate in steps of 9 and use offset to 3x check.
            int count = 0;
            for (int i = 0; i < values.size(); i += 9) {
                Triangle triangle1 = new Triangle(new int[]{values.get(i    ), values.get(i + 3), values.get(i + 6)});
                Triangle triangle2 = new Triangle(new int[]{values.get(i + 1), values.get(i + 4), values.get(i + 7)});
                Triangle triangle3 = new Triangle(new int[]{values.get(i + 2), values.get(i + 5), values.get(i + 8)});

                if (triangle1.couldBeTriangle()) {
                    ++count;
                }
                if (triangle2.couldBeTriangle()) {
                    ++count;
                }
                if (triangle3.couldBeTriangle()) {
                    ++count;
                }
            }

            System.out.println("Count: " + count);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
