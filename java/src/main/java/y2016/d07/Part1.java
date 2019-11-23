package y2016.d07;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> lines = Files.readByLines("src/main/java/y2016/d07/small.txt");

        int count = 0;
        for (String line: lines) {
            String[] split = line.split("[\\[\\]]");
            if (!hasAbba(split[1]) && (hasAbba(split[0]) || hasAbba(split[2]))) {
                ++count;
            }
        }

        System.out.println(count);
    }

    private static boolean hasAbba(String in) {
        Pattern pattern = Pattern.compile(".*(\\w)(\\w)(\\2)(\\1).*");
        Matcher matcher = pattern.matcher(in);
        if (matcher.find()) {
            return !matcher.group(1).equals(matcher.group(2));
        }
        return false;
    }

}
