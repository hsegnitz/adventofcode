package y2015.d03;

public class PresentCourier {

    private int posX = 0;
    private int posY = 0;

    public PresentCourier() {
    }

    public void move(String direction) {
        switch (direction) {
            case "^":
                this.posY++;
                break;
            case "<":
                this.posX--;
                break;
            case "v":
                this.posY--;
                break;
            case ">":
                this.posX++;
                break;
        }
    }

    public String toString() {
        return posX + "x" + posY;
    }

}
