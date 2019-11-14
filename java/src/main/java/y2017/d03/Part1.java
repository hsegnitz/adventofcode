package y2017.d03;

import java.security.InvalidParameterException;

public class Part1 {
    private enum Direction {
        RIGHT, UP, LEFT, DOWN
    }

    public static void main(String[] args) {
        int in = 289326;
        int x = 0;
        int y = 0;
        int stepsInCurrentLayer = 1;
        Boolean newLayer = true;
        Direction direction = Direction.RIGHT;
        int pos = 1;
        while (true) {
            for (int j = 0; j < stepsInCurrentLayer; j++) {
                switch (direction) {
                    case UP:    ++y; break;
                    case DOWN:  --y; break;
                    case RIGHT: ++x; break;
                    case LEFT:  --x; break;
                }

                ++pos;
                if (pos == in) {
                    System.out.println(Math.abs(x) + Math.abs(y));
                    return;
                }
            }
            direction = turn(direction);
            newLayer = !newLayer;
            if (newLayer) {
                stepsInCurrentLayer += 1;
            }
        }

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
