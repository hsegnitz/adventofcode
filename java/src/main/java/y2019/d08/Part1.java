package y2019.d08;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part1 {

    private static final int width  = 25;
    private static final int height =  6;

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d08/in.txt");
        String theInput = input.get(0);

        int step = width * height;
        int numberOfZeros = Integer.MAX_VALUE;
        String candidate = "";
        for (int i = 0; i < theInput.length(); i += step) {
            String substr = theInput.substring(i, i+step);
            int zeroCount = countChars(substr, "0");
            if (zeroCount < numberOfZeros) {
                numberOfZeros = zeroCount;
                candidate = substr;
            }
        }

        System.out.println(countChars(candidate, "1") * countChars(candidate, "2"));

        for (int y = 0; y < height; y++) {
            for (int x = 0; x < width; x++) {
                int offset = (y*width)+x;
                while ("2".equals(theInput.substring(offset, offset+1))) {
                    offset += step;
                }
                System.out.print(
                        "1".equals(theInput.substring(offset, offset+1))
                        ? "X"
                        : " "
                );
            }
            System.out.println();
        }


    }

    private static int countChars(String input, String character) {
        return input.length() - input.replace(character, "").length();
    }

}
