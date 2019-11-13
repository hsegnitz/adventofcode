package y2015.d14;

public class Reindeer {

    private String name;
    private int    kilometersPerSecond;
    private int    burnLength;
    private int    rest;

    public Reindeer(String name, int kilometersPerSecond, int burnLength, int rest) {
        this.name = name;
        this.kilometersPerSecond = kilometersPerSecond;
        this.burnLength = burnLength;
        this.rest = rest;
    }

    public String getName() {
        return name;
    }

    public int kilometersAfter(int seconds) {
        boolean isResting = false;
        int distance = 0;

        while (seconds > 0) {
            if (isResting) {
                if (seconds >= rest) {
                    seconds -= rest;
                    isResting = false;
                } else {
                    return distance;
                }
            } else {
                if (seconds >= burnLength) {
                    distance += kilometersPerSecond * burnLength;
                    seconds -= burnLength;
                    isResting = true;
                } else {
                    distance += kilometersPerSecond * seconds;
                    return distance;
                }
            }
        }
        return -1;
    }
}
