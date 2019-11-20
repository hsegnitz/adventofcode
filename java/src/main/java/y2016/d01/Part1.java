package y2016.d01;

import common.Geometry;

import java.io.File;
import java.util.Scanner;

public class Part1 {

    private static enum Directions {
        NORTH, EAST, SOUTH, WEST
    }

    // private

    public static void main(String[] args) throws Exception {
        String[] chainOfCommand = readFile();
        int posX = 0;
        int posY = 0;
        Directions heading = Directions.NORTH;

        for (String command: chainOfCommand) {
            System.out.println(command);
            heading = turn(command, heading);
            int distance = Integer.parseInt(command.substring(1));
            switch (heading) {
                case NORTH: posY += distance; break;
                case EAST:  posX += distance; break;
                case SOUTH: posY -= distance; break;
                case WEST:  posX -= distance; break;
            }
        }

        System.out.println(Geometry.taxiDistance(0, 0, posX, posY));
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
