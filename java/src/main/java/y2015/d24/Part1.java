package y2015.d24;

import java.io.File;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Scanner;

public class Part1 {

    private static ArrayList<Integer> gifts;
    private static int sum;


    public static void main(String[] args) {
        gifts = in();

        System.out.println("total weight:" + sum);

        int weightPerGroup = sum / 3;
        System.out.println("weight per group:" + weightPerGroup);

    }


    private static ArrayList<Integer> in() {
        ArrayList<Integer> list = new ArrayList<>();
        File file = new File("src/main/java/y2015/d24/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                int temp = scanner.nextInt();
                list.add(temp);
                sum += temp;
                scanner.nextLine();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        return list;
    }

}
