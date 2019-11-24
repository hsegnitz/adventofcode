package y2016.d08;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    public static void main(String[] args) throws Exception {
        ArrayList<String> lines = Files.readByLines("src/main/java/y2016/d08/small.txt");
        Grid grid = new Grid();

        Pattern pattern1 = Pattern.compile("(\\d+)x(\\d+)");
        Pattern pattern2 = Pattern.compile("=(\\d+) by (\\d+)");

        for (String line: lines) {
            System.out.println(line);
            if (line.startsWith("rect")) {
                Matcher matcher = pattern1.matcher(line);
                matcher.find();
                grid.rect(matcher.group(1), matcher.group(2));
            } else {
                Matcher matcher = pattern2.matcher(line);
                matcher.find();
                if (line.startsWith("rotate row")) {
                    grid.rotRow(matcher.group(1), matcher.group(2));
                } else if (line.startsWith("rotate column")) {
                    grid.rotCol(matcher.group(1), matcher.group(2));
                } else {
                    throw new Exception ("huh?!");
                }
            }
            grid.print();
        }
    }

}
