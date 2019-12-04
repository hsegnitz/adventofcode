package y2019.d04;

public class Part1 {

    public static void main(String[] args) {
        int count1 = 0;
        for (int i = 367479; i <= 893698; i++) {
            if (isValid1(i)) {
                ++count1;
            }
        }
        System.out.println(count1);

        int count2 = 0;
        for (int i = 367479; i <= 893698; i++) {
            if (isValid2(i)) {
                ++count2;
            }
        }
        System.out.println(count2);
    }

    public static boolean isValid1(Integer input) {
        String in = input.toString();
        if (! in.matches("^\\d*(\\d)(\\1)\\d*$")) {
            return false;
        }

        return isAscending(in);
    }

    public static boolean isValid2(Integer input) {
        String in = input.toString();
        if (!isAscending(in)) return false;

        String in2 = in.replaceAll("(\\d)\\1{2,}", "x");
 //       System.out.println(in2);

        return in2.matches("^.*(\\d)(\\1).*$");
    }

    private static boolean isAscending(String in) {
        return Integer.parseInt(in.substring(0, 1)) <= Integer.parseInt(in.substring(1, 2))
                && Integer.parseInt(in.substring(1, 2)) <= Integer.parseInt(in.substring(2, 3))
                && Integer.parseInt(in.substring(2, 3)) <= Integer.parseInt(in.substring(3, 4))
                && Integer.parseInt(in.substring(3, 4)) <= Integer.parseInt(in.substring(4, 5))
                && Integer.parseInt(in.substring(4, 5)) <= Integer.parseInt(in.substring(5));
    }

}
