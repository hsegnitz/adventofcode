package y2019.d04;

public class Part1 {

    public static void main(String[] args) {
        int count = 0;
        for (int i = 367479; i <= 893698; i++) {
            if (isValid(i)) {
                ++count;
            }
        }
        System.out.println(count);
    }

    public static boolean isValid(Integer input) {
        String in = input.toString();
        if (! in.matches("^\\d*(\\d)(\\1)\\d*$")) {
            return false;
        }

        if (
                Integer.parseInt(in.substring(0, 1)) > Integer.parseInt(in.substring(1, 2))
                || Integer.parseInt(in.substring(1, 2)) > Integer.parseInt(in.substring(2, 3))
                || Integer.parseInt(in.substring(2, 3)) > Integer.parseInt(in.substring(3, 4))
                || Integer.parseInt(in.substring(3, 4)) > Integer.parseInt(in.substring(4, 5))
                || Integer.parseInt(in.substring(4, 5)) > Integer.parseInt(in.substring(5))
        ){
            return false;
        }

        return true;
    }

}
