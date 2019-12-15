package y2019.d10;

import common.AocMath;
import common.Files;

import java.io.IOException;
import java.util.ArrayList;

public class Part1 {

    private static char[][] map = new char[33][33];


    public static void main(String[] args) throws IOException {
        readMap();
        printMap();

        int maxSeen = 0;

        int asteroidsSeen2 = countVisibleAsteroids(13, 11);
        System.out.println("manual input: " + asteroidsSeen2);

/*  */
        //iterate over all points
        for (int candidateLine = 0; candidateLine < map.length; candidateLine++) {
            for (int candidateCol = 0; candidateCol < map.length; candidateCol++) {
                if (map[candidateLine][candidateCol] != '#') {
                    continue;
                }
                int asteroidsSeen = countVisibleAsteroids(candidateLine, candidateCol);
                System.out.println("" + candidateLine + "x" + candidateCol + ":" + asteroidsSeen);
                maxSeen = Math.max(maxSeen, asteroidsSeen);
            }
        }
        System.out.println(maxSeen);
/*  */
    }

    private static int countVisibleAsteroids(int candidateLine, int candidateCol) {
        int count = 0;
        for (int line = 0; line < map.length; line++) {
            for (int col = 0; col < map.length; col++) {
                if (line == candidateLine && col == candidateCol) {
                    System.out.print('@');
                    continue;
                }
                if (map[line][col] != '#') {
                    System.out.print('.');
                    continue;
                }

                int deltaLine = Math.abs(candidateLine - line);
                int deltaCol  = Math.abs(candidateCol - col);

                int stepCol;
                int stepLine;

                long gcd = AocMath.greatestCommonDivisor(deltaCol, deltaLine);

                if (1 == gcd) {  // no field inbetween -> visible.
                    System.out.print('S');
                    count++;
                    continue;
                } else if (isDiagonal(deltaCol, deltaLine) || deltaCol == 0 || deltaLine == 0) {
                    stepCol  = (col  != candidateCol)  ? 1 : 0;
                    stepLine = (line != candidateLine) ? 1 : 0;
                } else {
                    stepCol  = deltaCol  / (int)gcd;
                    stepLine = deltaLine / (int)gcd;
                    // System.out.println("   " + stepCol + ":" + stepLine + "   ");
                }

                boolean found = false;
                int lineSign = (line > candidateLine) ? 1 : -1;
                int colSign  = (col  > candidateCol)  ? 1 : -1;

                int i = 1;
                int checkLine = candidateLine + (i * stepLine * lineSign);
                int checkCol  = candidateCol  + (i * stepCol  * colSign);
                while (!(checkCol == col && checkLine == line)) {
                    if (map[checkLine][checkCol] == '#') {
                        System.out.print('h');
                        found = true;
                        break;
                    }
                    checkLine = candidateLine + (i * stepLine * lineSign);
                    checkCol  = candidateCol  + (i * stepCol  * colSign);
                    i++;
                }

                if (!found) {
                    System.out.print('S');
                    count++;
                }
            }
            System.out.println();
        }
        return count;
    }

    private static boolean isDiagonal (int deltaCol, int deltaLine) {
        int absDeltaCol  = Math.abs(deltaCol);
        int absDeltaLine = Math.abs(deltaLine);
        return absDeltaCol == absDeltaLine;
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
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d10/in.txt");
        int line = 0;
        for (String sline: input) {
            int col = 0;
            for (char character: sline.trim().toCharArray()) {
                map[line][col] = character;
                ++col;
            }
            ++line;
            //System.out.println(line);
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
