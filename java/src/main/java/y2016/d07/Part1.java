package y2016.d07;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> lines = Files.readByLines("src/main/java/y2016/d07/in.txt");

        int countTLS = 0;
        int countSSL = 0;
        for (String line: lines) {
            System.out.println(line + " --- " + hasTLS(line));
            if (hasTLS(line)) {
                ++countTLS;
            }
            if (hasSSL(line)) {
                ++countSSL;
            }
        }

        System.out.println(countTLS);
        System.out.println(countSSL);
    }

    private static boolean hasTLS(String line) {
        String[] split = line.split("[\\[\\]]");
        boolean outsideFound = false;
        for (int i = 0; i < split.length; i++) {  // always an odd number of strings, the even ones are within brackets.
            if (0 == i % 2 && hasAbba(split[i])) {
                outsideFound = true;
            } else if (1 == i % 2 && hasAbba(split[i])) {  // inside one found -- immediate fail!
                return false;
            }
        }
        return outsideFound;
    }

    private static boolean hasSSL(String line) {
        String[] split = line.split("[\\[\\]]");

        ArrayList<String> outer = new ArrayList<>();
        ArrayList<String> inner = new ArrayList<>();

        for (int i = 0; i < split.length; i++) {  // always an odd number of strings, the even ones are within brackets.
            if (0 == i % 2) {
                outer.add(split[i]);
            } else {
                inner.add(split[i]);
            }
        }

        ArrayList<String> abas = getAbas(outer);
        for (String aba: abas) {
            if (hasBab(aba, inner)) {
                return true;
            }
        }

        return false;
    }

    private static boolean hasBab(String aba, ArrayList<String> inner) {
        String bab = String.valueOf(aba.charAt(1)) + aba.charAt(0) + aba.charAt(1);
        System.out.println(bab);

        for (String in: inner) {
            if (in.contains(bab)) {
                return true;
            }
        }

        return false;
    }

    private static ArrayList<String> getAbas(ArrayList<String> outer) {
        ArrayList<String> abas = new ArrayList<>();

        for (String elem: outer) {
            // can't use "match all" as we need to cover overlapping patterns too!
            for (int i = 0; i < elem.length()-2; i++) {
                String substr = elem.substring(i, i+3);
                if (substr.matches("(\\w)(\\w)(\\1)")) {
                    abas.add(substr);
                }
            }
        }
        return abas;
    }

    private static boolean hasAbba(String in) {
        Pattern pattern = Pattern.compile("(\\w)(\\w)(\\2)(\\1)");
        Matcher matcher = pattern.matcher(in);
        while (matcher.find()) {
            if (!matcher.group(1).equals(matcher.group(2))) {
                return true;
            }
        }
        return false;
    }

}
