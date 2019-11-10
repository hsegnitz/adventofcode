package y2015.d08;

import y2015.d07.Gate;

import java.io.File;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d08/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            String rawLine = "";
            int codeChars   = 0;
            int memoryChars = 0;
            while (scanner.hasNextLine()) {
                rawLine = scanner.nextLine();
                Line line = new Line(rawLine);
                codeChars += line.codeChars();
                memoryChars += line.memoryChars();
            }

            System.out.println("codeChars: "   + codeChars);
            System.out.println("memoryChars: " + memoryChars);
            System.out.println("diff: " + (codeChars - memoryChars));

        } catch (Exception e) {
            System.out.println(e.getMessage());
            return;
        }

    }


}
