package y2016.d07;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> lines = Files.readByLines("src/main/java/y2016/d07/in.txt");

        int count = 0;
        for (String line: lines) {
            System.out.println(line + " --- " + hasTLS(line));
            if (hasTLS(line)) {
                ++count;
            }
        }

        System.out.println(count);
    }

    private static boolean hasTLS(String line) {
        String[] split = line.split("[\\[\\]]");
        boolean outsideFound = false;
        for (int i = 0; i < split.length; i++) {  // always an odd number of strings, the even ones are within brackets.
            if (0 == i % 2 && hasAbba(split[i])) {
                outsideFound = true;
            } else if (1 == i % 2 && hasAbba(split[i])) {  // inside one found -- immediate fail!
                return false;
            }
        }
        return outsideFound;
    }

    private static boolean hasAbba(String in) {
        Pattern pattern = Pattern.compile("(\\w)(\\w)(\\2)(\\1)");
        Matcher matcher = pattern.matcher(in);
        while (matcher.find()) {
            if (!matcher.group(1).equals(matcher.group(2))) {
                return true;
            }
        }
        return false;
    }

}
