package y2016.d14;

import org.apache.commons.codec.binary.Hex;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.HashMap;
import java.util.HashSet;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part2 {

    private static MessageDigest md5;
    private static Pattern pattern1 = Pattern.compile("([a-f0-9])(\\1{2})");
    // private static String salt = "abc";
    private static String salt = "cuanljph";

    private static HashMap<Integer, String> hashMap = new HashMap<Integer, String>();

    public static void main(String[] args) throws NoSuchAlgorithmException {
        md5 = MessageDigest.getInstance("MD5");

        HashSet<String> keys = new HashSet<String>();

        int count = 0;
        while (keys.size() < 64) {
            String hash = hashOrDie(count);
            String result3 = getCharOfSequenceOfThree(hash);

            if (null != result3) {

                String hash2;
                for (int i = count + 1; i < count + 1000; i++) {
                    hash2 = hashOrDie(i);
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

    private static String hashOrDie(int count) {
        if (hashMap.containsKey(count)) {
            return hashMap.get(count);
        }

        String hash = getMd5Hex(salt + count);
        for (int i = 0; i < 2016; i++ ) {
            hash = getMd5Hex(hash);
        }
        hashMap.put(count, hash);
        return hash;
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
