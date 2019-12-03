package y2017.d03;

import java.security.InvalidParameterException;

public class Part2 {
    private enum Direction {
        RIGHT, UP, LEFT, DOWN
    }

    private static int[][] matrix = new int[2000][2000];

    public static void main(String[] args) {
        int in = 289326;
        int x = 1000;
        int y = 1000;
        int stepsInCurrentLayer = 1;

        matrix[x][y] = 1;

        Boolean newLayer = true;
        Direction direction = Direction.RIGHT;
        while (true) {
            for (int j = 0; j < stepsInCurrentLayer; j++) {
                switch (direction) {
                    case UP:    ++y; break;
                    case DOWN:  --y; break;
                    case RIGHT: ++x; break;
                    case LEFT:  --x; break;
                }

                int sum = sumNeighbors(x, y);
                if (sum >= in) {
                    System.out.println(sum);
                    System.exit(0);
                }

                matrix[x][y] = sumNeighbors(x, y);
            }
            direction = turn(direction);
            newLayer = !newLayer;
            if (newLayer) {
                stepsInCurrentLayer += 1;
            }
        }

    }

    private static int sumNeighbors(int x, int y) {
        return matrix[x-1][y-1] + matrix[x][y-1] + matrix[x+1][y-1]
            +  matrix[x-1][y]                    + matrix[x+1][y]
            +  matrix[x-1][y+1] + matrix[x][y+1] + matrix[x+1][y+1];
    }

    private static Direction turn(Direction direction) throws InvalidParameterException {
        switch (direction) {
            case UP:    return Direction.LEFT;
            case DOWN:  return Direction.RIGHT;
            case RIGHT: return Direction.UP;
            case LEFT:  return Direction.DOWN;
        }
        throw new InvalidParameterException("This should not happen!!111oneeleven");
    }
}
