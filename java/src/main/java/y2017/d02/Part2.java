package y2017.d02;

import java.io.File;
import java.util.Scanner;

public class Part2 {

    public static void main(String[] args) {
        File file = new File("src/main/java/y2017/d02/in.txt");
        try {
            Scanner scanner = new Scanner(file);
            String line = "";
            int checksum = 0;
            while (scanner.hasNextLine()) {
                line = scanner.nextLine();
                String[] split = line.split("\t");
                int divResult = 0;

                for (String number: split) {
                    int n = Integer.parseInt(number);
                    for (String number2: split) {
                        int n2 = Integer.parseInt(number2);
                        if (n == n2) {
                            continue;
                        }

                        if (n % n2 == 0) {
                            divResult = n / n2;
                        }
                    }
                }

                checksum += divResult;
            }

            System.out.println("Checksum: " + checksum);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

    }

}
