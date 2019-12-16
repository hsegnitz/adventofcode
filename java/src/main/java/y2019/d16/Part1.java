package y2019.d16;

import java.util.LinkedList;

public class Part1 {

    private static String small1 = "12345678";
    private static String small2 = "80871224585914546619083218645595";
    private static String small3 = "19617804207202209144916044189917";
    private static String small4 = "69317163492948606335995924319873";
    private static String input  = "59709511599794439805414014219880358445064269099345553494818286560304063399998657801629526113732466767578373307474609375929817361595469200826872565688108197109235040815426214109531925822745223338550232315662686923864318114370485155264844201080947518854684797571383091421294624331652208294087891792537136754322020911070917298783639755047408644387571604201164859259810557018398847239752708232169701196560341721916475238073458804201344527868552819678854931434638430059601039507016639454054034562680193879342212848230089775870308946301489595646123293699890239353150457214490749319019572887046296522891429720825181513685763060659768372996371503017206185697";

    public static void main(String[] args) {
        String out = input;
        for (int i = 0; i < 100; i++) {
//            out = calcPhase(out);
//            System.out.println(out);
        }

        // part 1
        System.out.println(out.substring(0, 8));

        // part2
        // so, this has to have a secret as we don't have roughly 25hours of CPU time to solve this the brute force way.
        // * just doing it for the numbers after offset -> nope
        // * last digit is always the same
        // * second to last digit rotates in a 10 phase
        // * the ones before even slower, but they repeat...
        // * when there are blocks of repeating zeros in one line, the next line has whatever digit is in there repeated in the same place
        // * to be precise repeated even once more!
        // * when there are repeated ones, the digits decrease by 1 below the ones
        // * same with 2s, decreasing by two
        // * and actually, with modulo applied, it works for all digits  Oo
        // * sooo.... newline[x] = newline[x-1] - oldline[x] or something
        // * damnit, that only works for numbers near the end and we need the previous ones anyways...
        // ... the end is alwoys the same ...
        // that formula can go the other way round actually => newline[x] = newline[x+1] + oldline[x]   (and mod applied!!!)  !!


        // part 2
        String out2 = longInput(input);
        System.out.println(out2);
        int offset = Integer.parseInt(out2.substring(0, 7));
        System.out.println(offset);

        String remainder = out2.substring(offset);
        System.out.println(remainder);

        // make the hind part of the string into an array of ints to not go back and forth with a string
        int[] temp = new int[remainder.length()];
        int i = 0;
        for (String x: remainder.split("")) {
            temp[i++] = Integer.parseInt(x);
        }

        for (i = temp.length-10; i < temp.length; i++) {
            System.out.print(temp[i]);
        }
        System.out.println();


        System.out.println(temp.length);
        for (i = 0; i < 100; i++) {
            for (int pos = temp.length - 2; pos >= 0; pos--) {
                int a = temp[pos + 1];
                int b = temp[pos];
                int newNumber = a + b;
                temp[pos] = Math.abs(newNumber % 10);
            }
        }

        for (i = 0; i < 8; i++) {
            System.out.print(temp[i]);
        }
        System.out.println();
    }

    private static String longInput(String input) {
        StringBuilder out = new StringBuilder();
        for (int i = 0; i < 10000; i++) {
            out.append(input);
        }
        return out.toString();
    }

    private static String calcPhase(String input) {
        StringBuilder out = new StringBuilder();

        for (int i = 0; i < input.length(); i++) {
            LinkedList<Integer> multiplicands = getListOfMultiplicands(i+1, input.length());
            int newNum = 0;
            for (int j = 0; j < input.length(); j++) {
                newNum += Integer.parseInt(input.substring(j, j+1)) * multiplicands.get(j);
            }
            out.append(Math.abs(newNum % 10));
        }

        return out.toString();
    }

    private static LinkedList<Integer> getListOfMultiplicands(int phase, int length) {
        LinkedList<Integer> out = new LinkedList<>();
        int[] elements = {0, 1, 0, -1};

        for (int i = 0; i <= length; i+= phase) {
            int toAdd = elements[(i/phase) % elements.length];
            for (int j = 0; j < phase; j++) {
                out.add(toAdd);
            }
        }
        out.removeFirst();
        return out;
    }
}
