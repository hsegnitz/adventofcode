package y2019.d10;

import common.Files;
import common.Geometry;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Map;
import java.util.TreeMap;

public class Part2 {

    private static char[][] map = new char[33][33];

    // from part 1
    private static int laserX = 29;
    private static int laserY = 28;

    private static TreeMap<Double, TreeMap<Integer, Asteroid>> deathRow = new TreeMap<>();

    public static void main(String[] args) throws IOException {
        readMap();

        int count = 0;

        while (count < 200) {
            for (Map.Entry<Double, TreeMap<Integer, Asteroid>> sub: deathRow.entrySet()) {
                if (sub.getValue().size() > 0) {
                    Map.Entry<Integer, Asteroid> first = sub.getValue().firstEntry();
                    sub.getValue().remove(first.getKey());
                    System.out.println("" + count + ": " + first.getValue().getPosX() + "x" + first.getValue().getPosY());
                    count++;
                }
            }
        }
    }


    private static class Asteroid {
        private int posX;
        private int posY;
        private int distance;  // taxicab geometry!
        private double angle;

        public Asteroid(int posX, int posY) {
            this.posX = posX;
            this.posY = posY;
            this.distance = Geometry.taxiDistance(laserX, laserY, posX, posY);
            this.angle();
        }

        private void angle() {
            double radians = Math.atan2((double)(posY - laserY), (double)(posX - laserX));
            radians = (radians + 2 * Math.PI) % (2 * Math.PI);
            this.angle = (radians + Math.PI / 2) % (2 * Math.PI);
        }

        public int getPosX() {
            return posX;
        }

        public int getPosY() {
            return posY;
        }

        public int getDistance() {
            return distance;
        }

        public double getAngle() {
            return angle;
        }
    }

    private static void readMap() throws IOException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d10/in.txt");
        int line = 0;
        for (String sline: input) {
            int col = 0;
            for (char character: sline.trim().toCharArray()) {
                if ('#' != character) {
                    ++col;
                    continue;
                }
                if (col == laserX && line == laserY) {
                    ++col;
                    continue;
                }

                Asteroid ast = new Asteroid(col, line);

                if (!deathRow.containsKey(ast.getAngle())) {
                    TreeMap<Integer, Asteroid> sub = new TreeMap<>();
                    deathRow.put(ast.getAngle(), sub);
                }

                deathRow.get(ast.getAngle()).put(ast.getDistance(), ast);
                ++col;
            }
            ++line;
        }
    }
}
