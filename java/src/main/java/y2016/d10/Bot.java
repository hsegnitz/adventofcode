package y2016.d10;

import java.util.HashMap;

public class Bot {

    private static HashMap<Integer, Bot> botMap = new HashMap<Integer, Bot>();

    private Bot highBot;
    private Bot lowBot;

    private Integer value1;
    private Integer value2;

    public void setHighBot(Bot highBot) {
        this.highBot = highBot;

        passOnValues();
    }

    public void setLowBot(Bot lowBot) {
        this.lowBot = lowBot;

        passOnValues();
    }

    public void setValue(int value) {
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
        if (null == highBot || null == lowBot || null == value1 || null == value2) {
            return;  // not ready!
        }

        int max = Math.max(value1, value2);
        int min = Math.min(value1, value2);
    }
}
