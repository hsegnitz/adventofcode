package y2016.d02;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part1 {

    private static class NumberPad {
        private int[][] pad = {
                {1, 2, 3},
                {4, 5, 6},
                {7, 8, 9},
        };

        private int posX = 1;
        private int posY = 1;

        public int read() {
            return pad[posY][posX];
        }

        public void move(char direction) {
            switch (direction) {
                case 'U': posY = Math.max(0, posY-1); break;
                case 'L': posX = Math.max(0, posX-1); break;
                case 'R': posX = Math.min(2, posX+1); break;
                case 'D': posY = Math.min(2, posY+1); break;
            }
        }

    }


    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> instructions = Files.readByLines("src/main/java/y2016/d02/in.txt");

        NumberPad pad = new NumberPad();

        for (String line: instructions) {
            for (int i = 0; i < line.length(); i++) {
                pad.move(line.charAt(i));
            }
            System.out.print(pad.read());
        }
        System.out.println("");
    }

}
