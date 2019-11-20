package common;

public class Geometry {
    public static int taxiDistance(int startX, int startY, int endX, int endY) {
        return Math.abs(endX - startX) + Math.abs(endY - startY);
    }
}
