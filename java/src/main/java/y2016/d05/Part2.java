package y2016.d05;

import jdk.internal.joptsimple.internal.Strings;
import org.apache.commons.codec.binary.Hex;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Arrays;

public class Part2 {

    private static String input = "ffykfhsq";
    private static int zerolength = 5;
    private static MessageDigest md5;


    public static void main(String[] args) throws NoSuchAlgorithmException {
        md5 = MessageDigest.getInstance("MD5");

        String hash = "1234567980";
        int count = 0;
        String[] password = {
                "", "", "", "", "", "", "", ""
        };
        while (true) {
            while (!"00000".equals(hash.substring(0, zerolength))) {
                ++count;
                hash = getMd5Hex(input + count);
            }

            String numeric = hash.substring(zerolength, zerolength+1);
            if (numeric.matches("\\d")) {
                Integer position = Integer.parseInt(numeric);
                String  letter = hash.substring(zerolength+1, zerolength+2);

                if (position < 8 && password[position].equals("")) {
                    password[position] = letter;
                }
            }

            for (String s: password) {
                System.out.print(s);
            }
            System.out.println("");
            hash = "3472628347623847624";
        }

        //System.out.println(password);
    }

    private static String getMd5Hex(String input) {
        byte[] hashInBytes = md5.digest(input.getBytes());
        return Hex.encodeHexString(hashInBytes);
    }
}
