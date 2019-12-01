package y2019.d01;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part1 {

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d01/in.txt");

        Integer fuel = 0;
        Integer fuelFuel = 0;
        for (String s: input) {
            fuel += calcFuel(s);
            fuelFuel += calcFuelFuel(s);
        }

        System.out.println(fuel);
        System.out.println(fuelFuel);
    }

    private static int calcFuel(String input) {
        return calcFuel(Integer.parseInt(input));
    }

    private static int calcFuel(int mass) {
        int temp = (mass / 3) - 2;
        if (temp >= 0) {
            return temp;
        }
        return 0;
    }

    private static int calcFuelFuel(String input) {
        return calcFuelFuel(Integer.parseInt(input));
    }

    private static int calcFuelFuel(int input) {
        Integer sum = 0;
        Integer temp = calcFuel(input);
        while (temp > 0) {
            sum += temp;
            temp = calcFuel(temp);
        }
        return sum;
    }
}
