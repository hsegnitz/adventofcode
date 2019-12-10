package y2019.d10;

import common.Files;

import java.io.IOException;
import java.util.ArrayList;

public class Part1 {

    private static char[][] map = new char[32][32];


    public static void main(String[] args) throws IOException {
        readMap();
        printMap();
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

        System.out.println(map);
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
