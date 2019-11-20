package y2015.d07;

import java.util.HashMap;
import java.util.Map;

public class Wires {
    private HashMap<String, Integer> wires = new HashMap<String, Integer>();

    public Wires() {
    }

    public boolean hasWire(String wireName) {
        return wires.containsKey(wireName);
    }

    public Integer readWire(String wireName) {
        return wires.get(wireName) & 0xFFFF;
    }

    public void writeWire(String wireName, int value) {
        wires.put(wireName, value & 0xFFFF);
    }

    public void printWires() {
        for (Map.Entry<String, Integer> entry: wires.entrySet()) {
            System.out.println(entry.getKey() + ": " + entry.getValue());
        }
    }
}
