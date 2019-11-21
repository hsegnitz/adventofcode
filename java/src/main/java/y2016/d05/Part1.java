package y2016.d05;

import org.apache.commons.codec.binary.Hex;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class Part1 {

    private static String input = "ffykfhsq";
    private static int zerolength = 5;
    private static MessageDigest md5;


    public static void main(String[] args) throws NoSuchAlgorithmException {
        md5 = MessageDigest.getInstance("MD5");

        String hash = "1234567980";
        int count = 0;
        StringBuilder password = new StringBuilder();
        while (password.length() < 8) {
            while (!"00000".equals(hash.substring(0, zerolength))) {
                ++count;
                hash = getMd5Hex(input + count);
            }
            password.append(hash.substring(zerolength, zerolength+1));
            System.out.println(password);
            hash = "3472628347623847624";
        }

        System.out.println(password);
    }

    private static String getMd5Hex(String input) {
        byte[] hashInBytes = md5.digest(input.getBytes());
        return Hex.encodeHexString(hashInBytes);
    }
}
