package y2019.d22;

import common.Files;

import java.io.FileNotFoundException;
import java.math.BigInteger;
import java.util.ArrayList;
import java.util.Collections;

public class Part2 {

/*
Let's hope we don't need to copy arrays around all the time...
so...

ouch, this needs the value that lands in pos 2020 not the position 2020 lands in!
So in order to not copy billions of longs in RAM each turn (that's not gonna work anyways), we need to look at this
in reverse order.

// @TODO: really understand this!

 */

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d22/in.txt");
        Collections.reverse(input);

        BigInteger sizeOfDeck = new BigInteger("119315717514047");
        BigInteger times      = new BigInteger("101741582076661");
        BigInteger position   = new BigInteger("2020");  // indexed at 0!

        BigInteger calc1 = new BigInteger("1");
        BigInteger calc2 = new BigInteger("0");

        for (String command: input) {
            if (command.matches("deal into new stack")) {
                calc1 = calc1.multiply(new BigInteger("-1"));
                calc2 = calc2.add(new BigInteger("1")).multiply(new BigInteger("-1"));
            } else if (command.matches("cut (-?[\\d]+)")) {
                String amount = command.split(" ")[1];
                calc2 = calc2.add(new BigInteger(amount));
            } else if (command.matches("deal with increment ([\\d]+)")) {
                BigInteger p = new BigInteger(command.split(" ")[3]);
                p = p.modPow(sizeOfDeck.subtract(new BigInteger("2")), sizeOfDeck);
                calc1 = calc1.multiply(p);
                calc2 = calc2.multiply(p);
            }

            calc1 = calc1.mod(sizeOfDeck);
            calc2 = calc2.mod(sizeOfDeck);
        }

        BigInteger pow = calc1.modPow(times, sizeOfDeck);

        BigInteger result = pow.multiply(
                position
        ).add(
                calc2.multiply(
                        pow.add(sizeOfDeck)
                                .subtract(new BigInteger("1"))
                ).multiply(
                        calc1.subtract(
                                new BigInteger("1")
                        ).modPow(
                                sizeOfDeck.subtract(
                                        new BigInteger("2")
                                ), sizeOfDeck)
                )
        ).mod(sizeOfDeck);

        System.out.println(result);
    }

}
