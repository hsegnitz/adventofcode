package y2016.d10;

public class Bot implements Receiver {

    private int number;

    private Receiver highReceiver;
    private Receiver lowReceiver;

    private Integer value1;
    private Integer value2;

    public Bot(int number) {
        this.number = number;
    }

    public void setHighReceiver(Receiver highReceiver) {
        this.highReceiver = highReceiver;

        passOnValues();
    }

    public void setLowReceiver(Receiver lowReceiver) {
        this.lowReceiver = lowReceiver;

        passOnValues();
    }

    public void setValue(Integer value) {
        if (null == this.value1) {
            this.value1 = value;
            return;
        }

        if (null == this.value2) {
            this.value2 = value;
        } else {
            throw new RuntimeException("we already have two values!");
        }

        passOnValues();
    }

    private void passOnValues() {
        if (null == highReceiver || null == lowReceiver || null == value1 || null == value2) {
            return;  // not ready!
        }

        int max = Math.max(value1, value2);
        int min = Math.min(value1, value2);

        if (max == 61 && min == 17) {
            System.out.println("Exit condition, bot number: " + number);
        }

        this.highReceiver.setValue(max);
        this.lowReceiver.setValue(min);
    }
}
