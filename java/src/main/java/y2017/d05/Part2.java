package y2017.d05;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part2 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> rawProgram = Files.readByLines("src/main/java/y2017/d05/in.txt");
        ArrayList<Integer> program = new ArrayList<>();
        for (String line: rawProgram) {
            program.add(Integer.parseInt(line));
        }

        int step = 0;
        int position = 0;
        while (position < program.size()) {
            int newPosition = position + program.get(position);
            if (program.get(position) >= 3) {
                program.set(position, program.get(position)-1);
            } else {
                program.set(position, program.get(position)+1);
            }
            position = newPosition;
            ++step;
        }

        System.out.println(step);
    }


}
