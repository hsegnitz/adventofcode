package y2015.d08;

import java.io.File;
import java.util.Scanner;

public class Part1 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2015/d08/in.txt");
        String rawLine   = "";
        int codeChars    = 0;
        int memoryChars  = 0;
        int escapedChars = 0;
        try {
            Scanner scanner = new Scanner(file);
            while (scanner.hasNextLine()) {
                rawLine       = scanner.nextLine();
                Line line     = new Line(rawLine);
                codeChars    += line.codeChars();
                memoryChars  += line.memoryChars();
                escapedChars += line.escapedChars();
            }

        } catch (Exception e) {
            System.out.println(e.getMessage());
            return;
        }

        System.out.println("codeChars (Part1*2): "  + codeChars);
        System.out.println("memoryChars (Part1): "  + memoryChars);
        System.out.println("diff (Part1): "         + (codeChars - memoryChars));
        System.out.println("");
        System.out.println("escapedChars (Part2): " + escapedChars);
        System.out.println("diff (Part2): "         + (escapedChars - codeChars));
    }
}
