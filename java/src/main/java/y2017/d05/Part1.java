package y2017.d05;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> rawProgram = Files.readByLines("src/main/java/y2017/d05/small.txt");
        ArrayList<Integer> program = new ArrayList<>();
        for (String line: rawProgram) {
            program.add(Integer.parseInt(line));
        }

        int step = 0;
        int position = 0;
        while (position < program.size()) {
            int newPosition = program.get(position);
            program.set(position, program.get(position)+1);
            position = newPosition;
            ++step;
        }

        System.out.println(step);
    }


}
