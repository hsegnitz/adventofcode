package y2015.d04;

import org.apache.commons.codec.binary.Hex;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class Part2 {

    private static MessageDigest md5;

    public static void main(String[] args) throws NoSuchAlgorithmException {
        String input = "bgvyzdsv";
        int count = 0;

        md5 = MessageDigest.getInstance("MD5");

        String hash = "1234567980";
        while (!"000000".equals(hash.substring(0, 6))) {
            ++count;
            hash = getMd5Hex(input + count);
        }

        System.out.println(input + count);
    }

    private static String getMd5Hex(String input) {
        byte[] hashInBytes = md5.digest(input.getBytes());
        return Hex.encodeHexString(hashInBytes);
    }
}
