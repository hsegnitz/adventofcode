package y2015.d06;

public class Grid2 {

    private int[][] grid = new int[1000][1000];

    public void apply(Instruction instruction) throws RuntimeException {
        for (int i = instruction.getStartX(); i <= instruction.getEndX(); i++) {
            for (int j = instruction.getStartY(); j <= instruction.getEndY(); j++) {
                if (instruction.isToggle()) {
                    grid[i][j] += 2;
                } else if (instruction.isTurnOn()) {
                    grid[i][j] += 1;
                } else if (instruction.isTurnOff() && grid[i][j] > 0) {
                    grid[i][j] -= 1;
                }
            }
        }
    }

    public String toString() {
        StringBuilder out = new StringBuilder();
        for (int i = 0; i < 1000; i++) {
            for (int j = 0; j < 1000; j++) {
                out.append(String.format("%04d", grid[i][j]));
            }
            out.append("\r\n");
        }

        return out.toString();
    }

    public long countBrightness() {
        long brightness = 0L;
        for (int i = 0; i < 1000; i++) {
            for (int j = 0; j < 1000; j++) {
                brightness += grid[i][j];
            }
        }
        return brightness;
    }

}
