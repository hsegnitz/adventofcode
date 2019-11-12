package y2015.d11;

import java.util.ArrayList;
import java.util.Arrays;

public class Part1 {

    public static void main(String[] args) {
        String input = "cqjxjnds";

        while (!isValid(input)) {
            input = increment(input, 7);
        }
        System.out.println(input);
    }

    public static String increment(String input, int position) {
        StringBuilder out = new StringBuilder();
        out.append(input, 0, position);
        boolean incrementPrevious = false;
        switch (input.charAt(position)) {
            case 'a': out.append("b"); break;
            case 'b': out.append("c"); break;
            case 'c': out.append("d"); break;
            case 'd': out.append("e"); break;
            case 'e': out.append("f"); break;
            case 'f': out.append("g"); break;
            case 'g': out.append("h"); break;
            case 'h': out.append("j"); break;
            case 'j': out.append("k"); break;
            case 'k': out.append("m"); break;
            case 'm': out.append("n"); break;
            case 'n': out.append("p"); break;
            case 'p': out.append("q"); break;
            case 'q': out.append("r"); break;
            case 'r': out.append("s"); break;
            case 's': out.append("t"); break;
            case 't': out.append("u"); break;
            case 'u': out.append("v"); break;
            case 'v': out.append("x"); break;
            case 'x': out.append("y"); break;
            case 'y': out.append("z"); break;
            case 'z':
                out.append("a");
                incrementPrevious = true;
                break;
        }
        if (position + 1 < input.length()) {
            out.append(input.substring(position+1));
        }

        if (incrementPrevious) {
            return increment(out.toString(), position-1);
        }

        return out.toString();
    }

    public static boolean isValid(String input) {
        return hasNoIOL(input) && hasStraight(input) && hasDoublePairs(input);
    }

    public static boolean hasDoublePairs(String input) {
        char target = '5';
        for (int i = 0; i < input.length()-1; i++) {
            if (input.charAt(i) == input.charAt(i+1)) {
                if (target != '5' && target != input.charAt(i)) {
                    return true;
                }
                target = input.charAt(i);
                i++;
            }
        }

        return false;
    }

    public static boolean hasStraight(String input) {
        return input.matches(".*(abc|bcd|cde|def|efg|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz).*");
    }

    public static boolean hasNoIOL(String input) {
        return !input.matches("[iol]");
    }

}
