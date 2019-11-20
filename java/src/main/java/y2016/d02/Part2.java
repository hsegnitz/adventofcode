package y2016.d02;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part2 {

    private static class NumberPad {
        private String[][] pad = {
                {"-", "-", "1", "-", "-"},
                {"-", "2", "3", "4", "-"},
                {"5", "6", "7", "8", "9"},
                {"-", "A", "B", "C", "-"},
                {"-", "-", "D", "-", "-"},
        };

        private int posX = 0;
        private int posY = 2;

        public String read() {
            return pad[posY][posX];
        }

        public void move(char direction) {
            switch (direction) {
                case 'U': moveUp(); break;
                case 'L': moveLeft(); break;
                case 'R': moveRight(); break;
                case 'D': moveDown(); break;
            }
        }

        public void moveUp() {
            if (posY <= 0) {
                return;
            }
            if ("-".equals(pad[posY-1][posX])) {
                return;
            }
            --posY;
        }

        public void moveDown() {
            if (posY >= 4) {
                return;
            }
            if ("-".equals(pad[posY+1][posX])) {
                return;
            }
            ++posY;
        }

        public void moveLeft() {
            if (posX <= 0) {
                return;
            }
            if ("-".equals(pad[posY][posX-1])) {
                return;
            }
            --posX;
        }

        public void moveRight() {
            if (posX >= 4) {
                return;
            }
            if ("-".equals(pad[posY][posX+1])) {
                return;
            }
            ++posX;
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
