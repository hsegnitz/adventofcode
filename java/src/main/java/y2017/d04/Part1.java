package y2017.d04;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashSet;
import java.util.Set;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> lines = Files.readByLines("src/main/java/y2017/d04/in.txt");
        int valid      = 0;
        int noAnagrams = 0;

        for (String line: lines) {
            if (isValidPassphrase(line)) {
                valid++;
                if (hasNoAnagrams(line)) {
                    noAnagrams++;
                }
            }
        }

        System.out.println(valid);
        System.out.println(noAnagrams);
    }

    private static boolean isValidPassphrase(String phrase) {
        Set<String> unique = new HashSet<>();
        String[] split = phrase.split(" ");
        for (String s: split) {
            if (!unique.add(s)) {
                return false;
            }
        }
        return true;
    }

    private static boolean hasNoAnagrams(String phrase) {
        Set<String> unique = new HashSet<>();
        String[] split = phrase.split(" ");
        for (String s: split) {
            for (String t: split) {
                if (s.equals(t)) {
                    continue;
                }

                char[] c1 = stringToSortedCharArray(s);
                char[] c2 = stringToSortedCharArray(t);

                if (0 == Arrays.compare(c1, c2)) {
                    return false;
                }
            }
        }
        return true;
    }

    private static char[] stringToSortedCharArray(String word) {
        char[] chars = word.toCharArray();
        Arrays.sort(chars);
        return chars;
    }

}
