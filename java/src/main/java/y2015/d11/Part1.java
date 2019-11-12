package y2015.d11;

import java.util.ArrayList;
import java.util.Arrays;

public class Part1 {

    public static void main(String[] args) {
        String input = "cqjxjabc";

        System.out.println(isValid(input));
    }

    public static boolean isValid(String input) {

        return hasNoIOL(input) && hasStraight(input);
    }

    public static boolean hasStraight(String input) {
        return input.matches(".*(abc|bcd|cde|def|efg|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz).*");
    }

    public static boolean hasNoIOL(String input) {
        return !input.matches("[iol]");
    }

}
