package y2015.d16;

import java.io.File;
import java.util.ArrayList;
import java.util.Scanner;
import java.util.Set;

public class Part1 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d16/in.txt");
        String rawLine   = "";
//        ArrayList<Sue> sues = new ArrayList<>();

        try {
            Sue target = new Sue(0);
            target.setValue("children",    3);
            target.setValue("cats",        7);
            target.setValue("samoyeds",    2);
            target.setValue("pomeranians", 3);
            target.setValue("akitas",      0);
            target.setValue("vizslas",     0);
            target.setValue("goldfish",    5);
            target.setValue("trees",       3);
            target.setValue("cars",        2);
            target.setValue("perfumes",    1);

            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                rawLine = scanner.nextLine();
                String[] split = rawLine.replaceAll("[:,]", "").split(" ");

                Sue sue = new Sue(Integer.parseInt(split[1]));
                sue.setValue(split[2], Integer.parseInt(split[3]));
                sue.setValue(split[4], Integer.parseInt(split[5]));
                sue.setValue(split[6], Integer.parseInt(split[7]));
//                sues.add(sue);

                if (target.equals(sue)) {
                    System.out.println(sue.getNumber());
                }

            }

        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }
}
