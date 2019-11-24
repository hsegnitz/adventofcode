package y2016.d09;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part2 {

    public static void main(String[] args) throws FileNotFoundException {

        ArrayList<String> in = Files.readByLines("src/main/java/y2016/d09/in.txt");

        String input = in.get(0);

        System.out.println(count(input));
    }

    private static long count(String packed) {
        long count = 0;
        Pattern marker = Pattern.compile("^\\((\\d+)x(\\d+)\\)");

        for (int i = 0; i < packed.length(); i++) {
            if (packed.charAt(i) != '(') {
                ++count;
                continue;
            }

            if (packed.substring(i).matches("^\\((\\d+)x(\\d+)\\).*")) {
                Matcher m = marker.matcher(packed.substring(i, Math.min(packed.length(), i + 100)));
                m.find();
                int length = Integer.parseInt(m.group(1));
                int times  = Integer.parseInt(m.group(2));
                i += 3 + m.group(1).length() + m.group(2).length();

                String clone = packed.substring(i, i+length);

                count += times * count(clone);
                i += length-1;
            }
        }

        return count;
    }

}
