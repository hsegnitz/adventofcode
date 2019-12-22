package y2019.d22;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;

public class Part1 {

/*
Let's hope we don't need to copy arrays around all the time...
so...

let's look at card #3 in a 0-9 stack:

deal into new stack means actually reverse the whole stack.
3 is in 4th position (COUNTING from 1) so after the operation it's in 4th from the end: 10-3 pos 7 ... or 9-3 -> value 6

cut N cards is moving the whole stack by N.
cut 3 cards, new position 3-3: 0
cut -3 cards, new position 3+3: 6
apply modulo 10 for rollover:
cut -8 cards, new position: 3+8 = 11 % 10 = 1
substract from .length() if negative
cut 4 cards, new position 3-4: -1 -> 10-1 = 9

deal with increment can be done with multiplying and modulo:
deal with 3 increment:
3*3 = 9
deal with 4 increment:
3*4 = 12 % 10 = 2

for this we index position at 0!

 */

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d10/in.txt");

        int sizeOfDeck = 10;
        int position = 2019;  // indexed at 0!

        // System.out.println(dealNew(sizeOfDeck, position));
        // System.out.println(cutCards(sizeOfDeck, position, -8));
        System.out.println(dealIncrement(sizeOfDeck, position, 4));
    }

    private static int dealNew(int sizeOfDeck, int position) {
        return sizeOfDeck - 1 - position;
    }

    private static int cutCards(int sizeOfDeck, int position, int amount) {
        int tempPosition = position - amount;
        tempPosition += sizeOfDeck;
        tempPosition %= sizeOfDeck;
        return tempPosition;
    }

    private static int dealIncrement(int sizeOfDeck, int position, int increment) {
        int tempPosition = position * increment;
        tempPosition %= sizeOfDeck;
        return tempPosition;
    }



}
