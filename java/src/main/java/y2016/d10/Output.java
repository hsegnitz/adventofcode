package y2016.d10;

public class Output implements Receiver {

    private int number;

    private Integer value;

    public Output(int number) {
        this.number = number;
    }

    public void setValue(Integer value) {
        this.value = value;
    }

    public int getNumber() {
        return number;
    }

    public Integer getValue() {
        return value;
    }
}
