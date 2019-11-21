package y2015.d03;

import java.io.File;
import java.io.FileReader;
import java.util.HashSet;

public class Part2 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d03/in.txt");
        PresentCourier santa     = new PresentCourier();
        PresentCourier roboSanta = new PresentCourier();
        HashSet<String> houses = new HashSet<String>();

        try {
            FileReader fr = new FileReader(file);
            int count = 0;
            int data = fr.read();

            houses.add(santa.toString());
            houses.add(roboSanta.toString());

            while (-1 != data) {
                String direction = Character.toString(data);

                if (count++ % 2 == 0) {
                    santa.move(direction);
                    houses.add(santa.toString());
                } else {
                    roboSanta.move(direction);
                    houses.add(roboSanta.toString());
                }

                data = fr.read();
            }

            System.out.println(houses.size());
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
