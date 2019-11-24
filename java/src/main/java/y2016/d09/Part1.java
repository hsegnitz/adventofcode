package y2016.d09;

import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    public static void main(String[] args) {

        String[] demo = {
                "ADVENT",
                "A(1x5)BC",
 /*               "(3x3)XYZ",
                "A(2x2)BCD(2x2)EFG",
                "(6x1)(1x3)A",
                "X(8x2)(3x3)ABCY",*/
        };

        for (String packed: demo) {
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
