package y2016.d14;

import org.apache.commons.codec.binary.Hex;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.HashSet;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    private static MessageDigest md5;
    private static Pattern pattern1 = Pattern.compile("([a-f0-9])(\\1{2})");

    public static void main(String[] args) throws NoSuchAlgorithmException {
        md5 = MessageDigest.getInstance("MD5");

        //String salt = "abc";
        String salt = "cuanljph";

        int count = 0;
        int hits = 0;

        String hash = getMd5Hex(salt + count);

        HashSet<String> keys = new HashSet<String>();

        while (keys.size() < 64) {
            hash = getMd5Hex(salt + count);
            String result3 = getCharOfSequenceOfThree(hash);

            if (null != result3) {

                String hash2;
                for (int i = count + 1; i < count + 1000; i++) {
                    hash2 = getMd5Hex(salt + i);
                    if (hasSequenceOfFive(hash2, result3)) {
                        System.out.print("three (" + result3 + "):" + hash + " @ " + count);
                        System.out.print("   five (" + result3 + "):" + hash2 + " @ " + i + "   |   ");
                        keys.add(hash);
                        System.out.println(keys.size());
                        break;
                    }
                }
            }
            ++count;
        }

        System.out.println(count-1);
    }

    private static String getCharOfSequenceOfThree(String hash) {
        Matcher matcher = pattern1.matcher(hash);
        if (matcher.find()) {
            return matcher.group(1);
        }
        return null;
    }

    private static boolean hasSequenceOfFive(String hash, String character) {
        return hash.matches(".*" + character + "{5}.*");
    }

    private static String getMd5Hex(String input) {
        byte[] hashInBytes = md5.digest(input.getBytes());
        return Hex.encodeHexString(hashInBytes);
    }

}
