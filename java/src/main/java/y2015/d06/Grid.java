package y2015.d06;

public class Grid {

    private boolean[][] grid = new boolean[1000][1000];

    public void apply(Instruction instruction) throws RuntimeException {
        for (int i = instruction.getStartX(); i <= instruction.getEndX(); i++) {
            for (int j = instruction.getStartY(); j <= instruction.getEndY(); j++) {
                if (instruction.isToggle()) {
                    grid[i][j] = Boolean.logicalXor(grid[i][j], true);
                } else if (instruction.isTurnOn()) {
                    grid[i][j] = true;
                } else if (instruction.isTurnOff()) {
                    grid[i][j] = false;
                } else {
                    throw new RuntimeException("You should not be able to reach this code, ever!");
                }
            }
        }
    }

    public String toString() {
        StringBuilder out = new StringBuilder();
        for (int i = 0; i < 1000; i++) {
            for (int j = 0; j < 1000; j++) {
                if (grid[i][j]) {
                    out.append("1");
                } else {
                    out.append("0");
                }
            }
            out.append("\r\n");
        }

        return out.toString();
    }

    public int countLights() {
        int count = 0;
        for (int i = 0; i < 1000; i++) {
            for (int j = 0; j < 1000; j++) {
                if (grid[i][j]) {
                    ++count;
                }
            }
        }
        return count;
    }

}
