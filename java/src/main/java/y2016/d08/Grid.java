package y2016.d08;

import y2015.d06.Instruction;

public class Grid {

    private boolean[][] grid = new boolean[6][50];

    public void rect(int x, int y) {
        for (int i = 0; i < y; i++) {
            for (int j = 0; j < x; j++) {
                grid[i][j] = true;
            }
        }
    }

    public void rect(String x, String y) {
        rect(
                Integer.parseInt(x),
                Integer.parseInt(y)
        );
    }

    public void rotRow (int row, int length) {
        boolean[] newRow = new boolean[50];

        for (int i = 0; i < 50; i++) {
            newRow[(i+length) % 50] = grid[row][i];
        }

        grid[row] = newRow;
    }

    public void rotRow (String row, String length) {
        rotRow(
                Integer.parseInt(row),
                Integer.parseInt(length)
        );
    }
    public void rotCol (int col, int length) {
        boolean[] newCol = new boolean[6];

        for (int i = 0; i < 6; i++) {
            newCol[(i+length)%6] = grid[i][col];
        }
        for (int i = 0; i < 6; i++) {
            grid[i][col] = newCol[i];
        }
    }

    public void rotCol (String col, String length) {
        rotCol(
                Integer.parseInt(col),
                Integer.parseInt(length)
        );
    }

    public void print() {
        int count = 0;
        for (boolean[] row: grid) {
            for (boolean cell: row) {
                if (cell) {
                    System.out.print('#');
                    ++count;
                } else {
                    System.out.print('.');
                }
            }
            System.out.println();
        }
        System.out.println("on: " + count);
    }
}
