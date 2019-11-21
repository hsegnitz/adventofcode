package y2015.d07;

import java.security.InvalidParameterException;
import java.util.function.IntBinaryOperator;

public class Gate {

    private String  wire1  = "";
    private Integer value1;
    private boolean value1Set = false;
    private String  wire2  = "";
    private Integer value2;
    private boolean value2Set = false;
    private String  command;
    private String  out;

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
            value1    = Integer.parseInt(input);
            value1Set = true;
        } else {
            wire1     = input;
        }
    }

    private void receiveSecondInput(String input) {
        if (input.matches("\\d+")) {
            value2    = Integer.parseInt(input);
            value2Set = true;
        } else {
            wire2     = input;
        }
    }

    private boolean hasValue1(Wires wires) {
        return value1Set || wires.hasWire(wire1);
    }

    private boolean hasValue2(Wires wires) {
        return value2Set || wires.hasWire(wire2);
    }

    private int getValue1(Wires wires) {
        if(wires.hasWire(wire1)) {
            return wires.readWire(wire1);
        }
        return value1;
    }

    private int getValue2(Wires wires) {
        if(wires.hasWire(wire2)) {
            return wires.readWire(wire2);
        }
        return value2;
    }

    public void compute(Wires wires) throws Exception {
        switch (command) {
            case "SET":
                if (hasValue2(wires)) {
                    //System.out.println("SET <" + out + "> to " + getValue2(wires));
                    wires.writeWire(out, getValue2(wires));
                }
                break;
            case "NOT":
                if (hasValue2(wires)) {
                    //System.out.println("NOT " + getValue2(wires) + " (" + (int) ~getValue2(wires) + ") stored in <" + out + ">");
                    wires.writeWire(out, ~getValue2(wires));
                }
                break;
            case "AND":
                if (hasValue1(wires) && hasValue2(wires)) {
                   //System.out.println("AND " + getValue1(wires) + ", " + getValue2(wires) + " stored in <" + out + ">");
                    IntBinaryOperator func = (a, b) -> a & b;
                    wires.writeWire(out, func.applyAsInt(getValue1(wires), getValue2(wires)));
                }
                break;
            case "OR":
                if (hasValue1(wires) && hasValue2(wires)) {
                   // System.out.println("OR " + getValue1(wires) + ", " + getValue2(wires) + " stored in <" + out + ">");
                    IntBinaryOperator func = (a, b) -> a | b;
                    wires.writeWire(out, func.applyAsInt(getValue1(wires), getValue2(wires)));
                }
                break;
            case "LSHIFT":
                if (hasValue1(wires) && hasValue2(wires)) {
               //     System.out.println("LSHIFT " + getValue1(wires) + ", " + getValue2(wires) + " stored in <" + out + ">");
                    IntBinaryOperator func = (a, b) -> a << b;
                    wires.writeWire(out, func.applyAsInt(getValue1(wires), getValue2(wires)));
                }
                break;
            case "RSHIFT":
                if (hasValue1(wires) && hasValue2(wires)) {
         //           System.out.println("RSHIFT " + getValue1(wires) + ", " + getValue2(wires) + " stored in <" + out + ">");
                    IntBinaryOperator func = (a, b) -> a >> b;
                    wires.writeWire(out, func.applyAsInt(getValue1(wires), getValue2(wires)));
                }
                break;
            default:
                throw new Exception("WTF?!");
        }
    }
}
