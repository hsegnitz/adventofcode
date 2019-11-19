package y2015.d24;

import java.io.File;
import java.util.ArrayList;
import java.util.Scanner;

public class Part1 {

    private static ArrayList<Integer> gifts;
    private static int sum;
    private static int targetWeight;
    private static int smallestGroupSize = Integer.MAX_VALUE;
    private static ArrayList<ArrayList<Integer>> candidates         = new ArrayList<ArrayList<Integer>>();
    private static ArrayList<ArrayList<Integer>> shortestCandidates = new ArrayList<ArrayList<Integer>>();

    public static void main(String[] args) {
        gifts = in();

        System.out.println("total weight:" + sum);

        targetWeight = sum / 3;
        System.out.println("weight per group:" + targetWeight);

        stack(new ArrayList<Integer>(), 0);

        for (ArrayList<Integer> candidate: candidates) {
            if (candidate.size() == smallestGroupSize) {
                shortestCandidates.add(candidate);
            }
        }

        System.out.println(candidates.size());
        System.out.println(shortestCandidates.size());

        for (ArrayList<Integer> candidate: shortestCandidates) {
            int qe = 1;
            for (Integer gift: candidate) {
                qe *= gift;
            }
            System.out.println(candidate + "; QE=" + qe);
        }
    }

    public static void stack(ArrayList<Integer> group, int depth) {
        int sum = arraySum(group);

        for (int i = depth; i < gifts.size(); i++) {
            int newSum = sum + gifts.get(i);

            if (newSum > targetWeight) {
                continue;
            }

            ArrayList<Integer> newGroup = (new ArrayList<>());
            newGroup.addAll(group);
            newGroup.add(gifts.get(i));

            if (newSum == targetWeight) {
                ArrayList<Integer> newTotal = (new ArrayList<>());
                newTotal.addAll(gifts);
                newTotal.removeAll(newGroup);
                if (isSubStackable(new ArrayList<Integer>(), newTotal, 0)) {
                    candidates.add(newGroup);
                    smallestGroupSize = Math.min(smallestGroupSize, newGroup.size());
                }
            } else if (newSum < targetWeight) {
                stack(newGroup, i + 1);
            }
        }
    }

    public static boolean isSubStackable(ArrayList<Integer> group, ArrayList<Integer> total, int depth) {
        int sum = arraySum(group);

        for (int i = depth; i < total.size(); i++) {
            int newSum = sum + total.get(i);

            if (newSum > targetWeight) {
                continue;
            }

            if (newSum == targetWeight) {
                return true;
            } else {  // (newSum < targetWeight)
                ArrayList<Integer> newGroup = (new ArrayList<>());
                newGroup.addAll(group);
                newGroup.add(total.get(i));

                if(isSubStackable(newGroup, total, i + 1)) {
                    return true;
                }
            }
        }

        return false;
    }


    private static int arraySum(ArrayList<Integer> group) {
        int sum = 0;
        for (Integer summand: group) {
            sum += summand;
        }
        return sum;
    }

    private static ArrayList<Integer> in() {
        ArrayList<Integer> list = new ArrayList<>();
        File file = new File("src/main/java/y2015/d24/small.txt");
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
