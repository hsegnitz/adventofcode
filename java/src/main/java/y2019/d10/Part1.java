package y2019.d10;

import common.Files;

import java.io.IOException;
import java.util.ArrayList;

public class Part1 {

    private static char[][] map = new char[32][32];


    public static void main(String[] args) throws IOException {
        readMap();
        printMap();

        int maxSeen = 0;

        //iterate over all points
        for (int candidateLine = 0; candidateLine < map.length; candidateLine++) {
            for (int candidateCol = 0; candidateCol < map.length; candidateCol++) {
                if (map[candidateLine][candidateCol] != '#') {
                    continue;
                }
                int asteroidsSeen = countVisibleAsteroids(candidateLine, candidateCol);
                maxSeen = Math.max(maxSeen, asteroidsSeen);
            }
            System.out.println();
        }
        System.out.println(maxSeen);
    }

    private static int countVisibleAsteroids(int candidateLine, int candidateCol) {
        int count = 0;
        for (int line = 0; line < map.length; line++) {
            for (int col = 0; col < map.length; col++) {
                if (line == candidateLine && col == candidateCol) {
                    continue;
                }
                if (map[line][col] != '#') {
                    continue;
                }

                

                // the check
            }
        }
        return count;
    }


    private static void readMap() throws IOException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d10/small1.txt");
        int line = 0;
        for (String sline: input) {
            int col = 0;
            for (char character: sline.toCharArray()) {
                map[line][col] = character;
                ++col;
            }
            ++line;
        }
    }

    private static void printMap()
    {
        for (int line = 0; line < map.length; line++) {
            for (int col = 0; col < map.length; col++) {
                System.out.print(map[line][col]);
            }
            System.out.println();
        }
    }

}
