package y2015.d18;

import y2015.d06.Grid;
import y2015.d07.Gate;

import java.io.File;
import java.util.Scanner;

public class Part1 {

    private static boolean[][] grid = new boolean[6][6];
//    private boolean[][] grid = new boolean[100][100];

    public static void main(String[] args) {
        readGrid();
        printGrid(grid);
        System.out.println();
        tick();
        printGrid(grid);
    }

    public static void readGrid () {
        try {
            File file = new File("src/main/java/y2015/d18/small.txt");
//            File file = new File("src/main/java/y2015/d18/in.txt");
            Scanner scanner = new Scanner(file);
            String rawLine = "";
            int line = 0;
            while (scanner.hasNextLine()) {
                rawLine = scanner.nextLine();
                for (int i = 0; i < rawLine.length(); i++) {
                    grid[line][i] = '#' == rawLine.charAt(i);
                }
                ++line;
            }

        } catch (Exception e) {
            e.printStackTrace();
            System.exit(42);
        }
    }

    public static void tick() {
        boolean[][] newGrid = new boolean[grid.length][grid.length];

        for (int i = 0; i < grid.length; i++) {
            for (int j = 0; j < grid[i].length; j++) {
                newGrid[i][j] = liveOrDie(i, j);
            }
            System.out.println();
        }

        System.out.println();
        grid = newGrid;
    }

    public static boolean liveOrDie(int i, int j) {
        int count  = grid[i][j] ? -1 : 0;  // the loops will count the spot itself as well, but we want the neighbour count here.
        int startY = (i == 0) ? 0 : i-1;
        int startX = (j == 0) ? 0 : j-1;
        int endY   = (i == grid.length-1) ? i : i+1;
        int endX   = (j == grid.length-1) ? j : j+1;

        for (int y = startY; y <= endY; y++) {
            for (int x = startX; x <= endX; x++) {
                if (grid[y][x]) {
                    ++count;
                }
            }
        }

        System.out.print(count);

        if (grid[i][j]) {
            if (count == 2 || count == 3) {
                return true;
            }
        } else {
            if (count == 3) {
                return true;
            }
        }
        return false;
    }

    public static void printGrid (boolean[][] grid) {
        int count = 0;
        for (boolean[] row: grid) {
            for (boolean bit: row) {
                if (bit) {
                    System.out.print("#");
                    ++count;
                } else {
                    System.out.print(".");
                }
            }
            System.out.println();
        }
        System.out.println("lights on: " + count);
    }
}
