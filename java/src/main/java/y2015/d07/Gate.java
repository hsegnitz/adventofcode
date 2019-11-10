package y2015.d07;

import java.security.InvalidParameterException;

public class Gate {

    private String wire1  = "";
    private Short  value1 = -1;
    private String wire2  = "";
    private Short  value2 = -1;
    private String command;
    private String out;

    public Gate(String raw) {
        String[] split = raw.split(" ");

        if (split.length == 5) {
            if (!split[3].equals("->")) {
                throw new InvalidParameterException("couldn't parse input");
            }

            receiveFirstInput(split[0]);
            receiveSecondInput(split[2]);
            command = split[1];
            out = split[4];
        }

        if (split.length == 4) {
            if (!split[2].equals("->")) {
                throw new InvalidParameterException("couldn't parse input");
            }

            receiveSecondInput(split[1]);
            command = split[0];
            out = split[3];
        }

        if (split.length == 3) {
            if (!split[1].equals("->")) {
                throw new InvalidParameterException("couldn't parse input");
            }

            receiveSecondInput(split[0]);
            command = "SET";
            out = split[2];
        }
    }

    private void receiveFirstInput(String input) {
        if (input.matches("\\d+")) {
            value1 = Short.parseShort(input);
        } else {
            wire1 = input;
        }
    }

    private void receiveSecondInput(String input) {
        if (input.matches("\\d+")) {
            value2 = Short.parseShort(input);
        } else {
            wire2 = input;
        }
    }

    private Short getValue1(Wires wires) {
        if(wires.hasWire(wire1)) {
            return wires.readWire(wire1);
        }
        return value1;
    }

    private Short getValue2(Wires wires) {
        if(wires.hasWire(wire2)) {
            return wires.readWire(wire2);
        }
        return value2;
    }

    public void compute(Wires wires) throws Exception {
        switch (command) {
            case "SET":
                wires.writeWire(out, getValue2(wires));
                break;
            case "NOT":
                if (-1 != getValue2(wires)) {
                    wires.writeWire(out, (short) ~getValue2(wires));
                }
                break;
            case "AND":
                if (-1 != getValue1(wires) && -1 != getValue2(wires)) {
                    wires.writeWire(out, (short) (getValue1(wires) & getValue2(wires)));
                }
                break;
            case "OR":
                if (-1 != getValue1(wires) && -1 != getValue2(wires)) {
                    wires.writeWire(out, (short) (getValue1(wires) | getValue2(wires)));
                }
                break;
            case "LSHIFT":
                if (-1 != getValue1(wires) && -1 != getValue2(wires)) {
                    wires.writeWire(out, (short)(getValue1(wires) << getValue2(wires)));
                }
                break;
            case "RSHIFT":
                if (-1 != getValue1(wires) && -1 != getValue2(wires)) {
                    wires.writeWire(out, (short)(getValue1(wires) >> getValue2(wires)));
                }
                break;
            default:
                throw new Exception("WTF?!");
        }
    }
}
