package y2015.d01;

import java.io.File;
import java.io.FileReader;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {

        File file = new File("y2015/d01/in.txt");
        try {
            int floor = 0;
            FileReader fr = new FileReader(file);

            int data = fr.read();
            while (-1 != data) {
                if (40 == data) {
                    floor++;
                } else if (41 == data) {
                    floor--;
                }
                data = fr.read();
            }

            System.out.println("Floor: " + floor);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

}
