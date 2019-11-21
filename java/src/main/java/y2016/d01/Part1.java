package y2016.d01;

import common.Geometry;

import java.io.File;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Scanner;
import java.util.Set;

public class Part1 {

    private static enum Directions {
        NORTH, EAST, SOUTH, WEST
    }

    private static Set<String> seen = new HashSet<>();

    public static void main(String[] args) throws Exception {
        String[] chainOfCommand = readFile();
        int posX = 0;
        int posY = 0;
        Directions heading = Directions.NORTH;

        //storePosition(posX, posY);
        for (String command: chainOfCommand) {
            // System.out.println(pos + " " + command);
            heading = turn(command, heading);
            int distance = Integer.parseInt(command.substring(1));
            switch (heading) {
                case NORTH:
                    for (int i = 0; i < distance; i++) {
                        storePosition(posX, posY);
                        posY++;
                    }
                    break;
                case EAST:
                    for (int i = 0; i < distance; i++) {
                        storePosition(posX, posY);
                        posX++;
                    }
                    break;
                case SOUTH:
                    for (int i = 0; i < distance; i++) {
                        storePosition(posX, posY);
                        posY--;
                    }
                    break;
                case WEST:
                    for (int i = 0; i < distance; i++) {
                        storePosition(posX, posY);
                        posX--;
                    }
                    break;
            }

        }

        System.out.println(Geometry.taxiDistance(0, 0, posX, posY));
    }

    private static void storePosition(int posX, int posY) {
        String pos = "" + posX + ":" + posY;
        System.out.println(pos);
        if (!seen.add(pos)) {
            System.out.println(Geometry.taxiDistance(0, 0, posX, posY));
            System.exit(0);
        }
    }


    private static Directions turn(String command, Directions current) throws Exception {
        if (command.charAt(0) == 'R') {
            switch (current) {
                case NORTH: return Directions.EAST;
                case EAST:  return Directions.SOUTH;
                case SOUTH: return Directions.WEST;
                case WEST:  return Directions.NORTH;
            }
        }
        switch (current) {
            case NORTH: return Directions.WEST;
            case EAST:  return Directions.NORTH;
            case SOUTH: return Directions.EAST;
            case WEST:  return Directions.SOUTH;
        }
        throw new Exception("Whaaaaaaaaa....???!!!!");
    }



    public static String[] readFile() {
        File file = new File("src/main/java/y2016/d01/in.txt");
        String rawLine = "";
        try {
            Scanner scanner = new Scanner(file);
            rawLine = scanner.nextLine();
            return rawLine.trim().split(", ");
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }

        return new String[]{""};
    }

}
