package common;

public class AocMath {
    public static long greatestCommonDivisor(long a, long b) {
        if (a == 0 || b == 0) {
            return a + b;
        } else {
            long max = Math.max(a, b);
            long min = Math.min(a, b);
            return greatestCommonDivisor(max % min, min);
        }
    }
}
