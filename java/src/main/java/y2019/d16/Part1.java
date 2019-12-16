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
            out = calcPhase(out);
        }

        System.out.println(out.substring(0, 8));
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
