package y2019.d10;

import common.Files;

import java.io.IOException;
import java.util.ArrayList;

public class Part1 {

    private static char[][] map = new char[33][33];


    public static void main(String[] args) throws IOException {
        readMap();
        printMap();

        int maxSeen = 0;

        int asteroidsSeen2 = countVisibleAsteroids(4, 3);

        //iterate over all points
        for (int candidateLine = 0; candidateLine < map.length; candidateLine++) {
            for (int candidateCol = 0; candidateCol < map.length; candidateCol++) {
                if (map[candidateLine][candidateCol] != '#') {
                    continue;
                }
                int asteroidsSeen = countVisibleAsteroids(candidateLine, candidateCol);
                maxSeen = Math.max(maxSeen, asteroidsSeen);
            }
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

                int deltaLine = Math.abs(candidateLine - line);
                int deltaCol  = Math.abs(candidateCol - col);

                int smallestPrimeFactor = getSmallestCommonPrimeFactor(deltaCol, deltaLine);
                int stepCol  = -1;
                int stepLine = -1;
                if (-1 == smallestPrimeFactor) {  // no field inbetween -> visible.
                    count++;
                    continue;
                } else if (smallestPrimeFactor == 1) {
                    stepCol  = (col  > candidateCol)  ? 1 : 0;
                    stepLine = (line > candidateLine) ? 1 : 0;
                    smallestPrimeFactor = Math.max(deltaCol, deltaLine);
                } else {
                    stepCol  = deltaCol / smallestPrimeFactor;
                    stepLine = deltaLine / smallestPrimeFactor;
                }

                boolean found = false;
                int lineSign = (deltaLine > candidateLine) ? 1 : -1;
                int colSign  = (deltaCol  > candidateCol)  ? 1 : -1;
                for (int i = 1; i < smallestPrimeFactor; i++) {
                    int checkLine = candidateLine + (i * stepLine * lineSign);
                    int checkCol  = candidateCol  + (i * stepCol  * colSign);
                    if (map[checkLine][checkCol] == '#') {
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    count++;
                }
            }
        }
        return count;
    }

    private static int getSmallestCommonPrimeFactor(int deltaCol, int deltaLine) {
        int absDeltaCol  = Math.abs(deltaCol);
        int absDeltaLine = Math.abs(deltaLine);
        if (absDeltaCol == absDeltaLine || absDeltaCol == 0 || absDeltaLine == 0) {
            return 1; // straight diagonals or horizontal/verticals
        }

        for (int i = 2; i <= Math.min(absDeltaCol, absDeltaLine); i++ ) {
            if (absDeltaCol % i == 0 && absDeltaLine % i == 0) {
                return i;
            }
        }

        return -1;
    }




    private static void readMap() throws IOException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d10/small1.txt");
        int line = 0;
        for (String sline: input) {
            int col = 0;
            for (char character: sline.trim().toCharArray()) {
                map[line][col] = character;
                ++col;
            }
            ++line;
            System.out.println(line);
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
