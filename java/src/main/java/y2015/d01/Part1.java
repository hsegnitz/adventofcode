package y2015.d01;

import java.io.File;
import java.io.FileReader;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {

        File file = new File("src/main/java/y2015/d01/in.txt");
        try {
            int floor = 0;
            int count = 0;
            boolean basementReached = false;
            FileReader fr = new FileReader(file);

            int data = fr.read();
            while (-1 != data) {
                if (40 == data) {
                    floor++;
                } else if (41 == data) {
                    floor--;
                }

                if (-1 == floor && !basementReached) {
                    System.out.println("Basement reached after (" + (count+1) + ") steps. (Part 2)");
                    basementReached = true;
                } else {
                    count++;
                }

                data = fr.read();
            }

            System.out.println("Floor (Part1): " + floor);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

}
