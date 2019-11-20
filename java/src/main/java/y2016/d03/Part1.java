package y2016.d03;

import java.io.File;
import java.util.Arrays;
import java.util.Scanner;

public class Part1 {

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
            int count = 0;
            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                String[] split = line.trim().split("\\s+");

                Triangle triangle = new Triangle(split);

                if (triangle.couldBeTriangle()) {
                    ++count;
                }
            }

            System.out.println("Count: " + count);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
