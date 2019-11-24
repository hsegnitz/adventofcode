package y2016.d09;

import common.Files;

import java.io.FileNotFoundException;
import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {

        ArrayList<String> in = Files.readByLines("src/main/java/y2016/d09/in.txt");

        for (String packed: in) {
            System.out.print(packed + " " + packed.length() + " ");
            System.out.println(unpack(packed));
        }
    }

    private static int unpack(String packed) {
        StringBuilder unpacked = new StringBuilder();
        Pattern marker = Pattern.compile("^\\((\\d+)x(\\d+)\\)");

        for (int i = 0; i < packed.length(); i++) {
            if (packed.charAt(i) != '(') {
                unpacked.append(packed.charAt(i));
                continue;
            }
            if (packed.substring(i).matches("^\\((\\d+)x(\\d+)\\).*")) {
                Matcher m = marker.matcher(packed.substring(i));
                m.find();
                int length = Integer.parseInt(m.group(1));
                int times  = Integer.parseInt(m.group(2));
                i += 3 + m.group(1).length() + m.group(2).length();

                String clone = packed.substring(i, i+length);
                for (int c = 0; c < times; c++) {
                    unpacked.append(clone);
                }

                i += length-1;
            }
        }

        System.out.print(unpacked + " ");
        return unpacked.length();
    }

}
