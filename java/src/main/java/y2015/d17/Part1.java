package y2015.d17;

import javax.swing.*;
import java.io.File;
import java.util.*;

public class Part1 {
    // private static int target = 25;  // small
    private static int target   = 150;    // in
    private static int count    =   0;
    private static int count2   =   0;
    private static int minCount = Integer.MAX_VALUE;
    private static ArrayList<Integer> allContainers = new ArrayList<>();


    public static void main(String[] args) {
        // allContainers = small();
        allContainers = in();

        calc(0, 0, 0);
        System.out.println(count);
        System.out.println(minCount);

        calcFixedNum(0, 0, 0);
        System.out.println(count2);
    }

    public static void calc(int sum, int depth, int containerCount) {
        ++containerCount;
        for (int i = depth; i < allContainers.size(); i++) {
            int newSum = sum + allContainers.get(i);
            if (newSum < target) {
                calc(newSum, i + 1, containerCount);
            } else if (newSum == target) {
                minCount = Math.min(minCount, containerCount);
                ++count;
            }
        }
    }

    public static void calcFixedNum(int sum, int depth, int containerCount) {
        ++containerCount;
        for (int i = depth; i < allContainers.size(); i++) {
            int newSum = sum + allContainers.get(i);
            if (newSum < target) {
                calcFixedNum(newSum, i + 1, containerCount);
            } else if (newSum == target) {
                if (containerCount == minCount) {
                    ++count2;
                }
            }
        }
    }

    private static ArrayList<Integer> small() {
        ArrayList<Integer> list = new ArrayList<>();
        list.add(20);
        list.add(15);
        list.add(10);
        list.add( 5);
        list.add( 5);

        return list;
    }

    private static ArrayList<Integer> in() {
        ArrayList<Integer> list = new ArrayList<>();
        File file = new File("src/main/java/y2015/d17/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                list.add(scanner.nextInt());
                scanner.nextLine();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        return list;
    }

}
