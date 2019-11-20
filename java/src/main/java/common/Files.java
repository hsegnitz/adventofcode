package common;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

public class Files {


    public static ArrayList<String> readByLines(String filename) throws FileNotFoundException {
        ArrayList<String> lines = new ArrayList<String>();
        File file = new File(filename);
        Scanner scanner = new Scanner(file);
        String line = "";
        while (scanner.hasNextLine()) {
            lines.add(scanner.nextLine());
        }
        return lines;
    }


}
