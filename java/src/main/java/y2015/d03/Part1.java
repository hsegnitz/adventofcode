package y2015.d03;

import java.io.File;
import java.io.FileReader;
import java.util.HashSet;

public class Part1 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d03/in.txt");
        PresentCourier santa = new PresentCourier();
        HashSet<String> houses = new HashSet<String>();

        try {
            FileReader fr = new FileReader(file);
            int data = fr.read();

            houses.add(santa.toString());

            while (-1 != data) {
                String direction = Character.toString(data);
                santa.move(direction);
                houses.add(santa.toString());
                data = fr.read();
            }

            System.out.println(houses.size());
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
