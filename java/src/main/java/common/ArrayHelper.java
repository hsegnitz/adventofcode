package common;

public class ArrayHelper {

    public static int arrayMax(int[] list) {
        int max = -1;
        for (int i: list) {
            max = Math.max(max, i);
        }
        return max;
    }
}
