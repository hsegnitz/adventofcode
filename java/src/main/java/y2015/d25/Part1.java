package y2015.d25;

public class Part1 {

    // IDEAs:
    /*
    Since every field is calculated from just one previous one, the mentioned coordinates in the table are actually just
    one position on a linear scale.
    we should calculate the position and then calculate the number up to that point (bruteforce)
    while doing so, it might be advisable to detect a patten -- e.g. look for a number we've seen already and then do
    a short cut.

    Position:

    numbers in row 1 are (1+2+3+4+.......n)
    the column below that....

    to get the sequence number:
    (1+2+3+4+........(targetCol+targetRow-1)) - targetRow + 1




     */

    private static int targetRow    = 2978;
    private static int targetColumn = 3083;

    public static void main(String[] args) {

        System.out.println(calcPosition(targetRow, targetColumn));

    }

    private static int calcPosition(int row, int col) {
        int upperBound = row + col - 1;
        int sum = ((upperBound * upperBound) + upperBound) / 2;
        return sum - row + 1;
    }


}
