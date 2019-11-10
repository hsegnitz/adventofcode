package y2015.d07;

import java.util.HashMap;

public class Wires {
    private HashMap<String, Short> wires = new HashMap<String, Short>();

    public Wires() {
    }

    public boolean hasWire(String wireName) {
        return wires.containsKey(wireName);
    }

    public Short readWire(String wireName) {
        return wires.get(wireName);
    }

    public void writeWire(String wireName, Short value) {
        wires.put(wireName, value);
    }

}
