package y2015.d06;

public class Instruction {

    private String command;
    private int startX;
    private int endX;
    private int startY;
    private int endY;

    public Instruction(String raw) {
        String[] split = raw.replaceFirst("turn ", "turn").split("[ ,]");
        command = split[0];
        startX  = Integer.parseInt(split[1]);
        startY  = Integer.parseInt(split[2]);
        endX    = Integer.parseInt(split[4]);
        endY    = Integer.parseInt(split[5]);

    }

    public boolean isToggle() {
        return command.equals("toggle");
    }

    public boolean isTurnOn() {
        return command.equals("turnon");
    }

    public boolean isTurnOff() {
        return command.equals("turnoff");
    }

    public int getStartX() {
        return startX;
    }

    public int getEndX() {
        return endX;
    }

    public int getStartY() {
        return startY;
    }

    public int getEndY() {
        return endY;
    }
}
