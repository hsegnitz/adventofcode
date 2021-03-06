package y2015.d20;

public class Part1 {

    public static void main(String[] args) {
        int target = 29000000;
        int upper = 1000000;
        int[] houses = new int[upper];

        for (int elf = 1; elf < upper; elf++) {
            for (int house = elf; house < upper; house += elf) {
                houses[house] += elf * 10;
            }
        }

        for (int house = 1; house < upper; house++) {
            if (houses[house] >= target) {
                System.out.println(house);
                break;
            }
        }
    }
}
