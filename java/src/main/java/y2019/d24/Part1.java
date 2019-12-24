package y2019.d24;

import java.util.HashSet;

public class Part1 {

    /** demo content * /
    private static boolean[][] map = {
            { false, false, false, false, true  },
            { true,  false, false, true,  false },
            { true,  false, false, true,  true  },
            { false, false, true,  false, false },
            { true,  false, false, false, false }
    };
    /*     */

    /** real content */
    private static boolean[][] map = {
            { false, true,  true,  true,  false },
            { true,  true,  false, false, false },
            { false, false, false, true,  true  },
            { false, true,  false, true,  false },
            { true,  false, true,  false, true  }
    };
    /*     */

    private static HashSet<String> seen = new HashSet<>();

    public static void main(String[] args) {

        String mapString = mapToString(map);
        seen.add(mapString);

        System.out.println(mapString);

        // System.out.println(mapToString(map));
        while (true) {
            boolean[][] newMap = new boolean[5][5];
            for (int y = 0; y < 5; y++) {
                for (int x = 0; x < 5; x++) {
                    newMap[y][x] = willLive(x, y);
                }
            }

            mapString = mapToString(newMap);
            map = newMap;

            if (!seen.add(mapString)) {
                break;
            }
            //System.out.println(mapString);
        }

        System.out.println(mapString);
        System.out.println(biodiversityRating(map));
    }

    private static int biodiversityRating(boolean[][] inMap) {
        int exponent = -1;
        int biodiversityRating = 0;
        for (boolean[] line: inMap) {
            for (boolean field: line) {
                exponent++;
                if (field) {
                    biodiversityRating += Math.pow(2, exponent);
                }
            }
        }
        return biodiversityRating;
    }

    private static boolean willLive(int x, int y) {
        int neighbors = countNeighbors(x, y);

        if (map[y][x]) {
            if (neighbors == 1) {
                return true;
            }
            return false;
        }

        if (!map[y][x]) {
            if (neighbors == 1 || neighbors == 2) {
                return true;
            }
            return false;
        }
        return false;
    }

    private static int countNeighbors(int x, int y) {
        int neighbors = 0;

        if (x > 0 && map[y][x-1]) neighbors++;
        if (x < 4 && map[y][x+1]) neighbors++;
        if (y > 0 && map[y-1][x]) neighbors++;
        if (y < 4 && map[y+1][x]) neighbors++;

        return neighbors;
    }

    private static String mapToString(boolean[][] map) {
        StringBuilder out = new StringBuilder();
        for (boolean[] line: map) {
            for (boolean field: line) {
                out.append(field ? "#" : ".");
            }
            out.append("\n");
        }
        return out.toString();
    }


}
