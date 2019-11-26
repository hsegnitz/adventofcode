package y2016.d10;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    private static HashMap<Integer, Bot>    botMap    = new HashMap<>();
    private static HashMap<Integer, Output> outputMap = new HashMap<>();

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> in = Files.readByLines("src/main/java/y2016/d10/in.txt");

        Pattern pattern1 = Pattern.compile("value (\\d+) goes to bot (\\d+)");
        Pattern pattern2 = Pattern.compile("bot (\\d+) gives low to (bot|output) (\\d+) and high to (bot|output) (\\d+)");

        for (String line: in) {
            Matcher m = pattern1.matcher(line);
            if (m.find()) {
                System.out.println("value " + line);
                getBot(Integer.parseInt(m.group(2))).setValue(Integer.parseInt(m.group(1)));
                continue;
            }

            m = pattern2.matcher(line);
            if (m.find()) {
                System.out.println("command " + line);
                Receiver lowReceiver  = getReceiver(m.group(2), m.group(3));
                Receiver highReceiver = getReceiver(m.group(4), m.group(5));

                getBot(Integer.parseInt(m.group(1))).setHighReceiver(highReceiver);
                getBot(Integer.parseInt(m.group(1))).setLowReceiver(lowReceiver);
                continue;
            }

            System.out.println("NOTHING!!! " + line);
        }
    }

    private static Receiver getReceiver(String type, String id) {
        if ("bot".equals(type)) {
            return getBot(Integer.parseInt(id));
        } else if ("output".equals(type)) {
            return getOutput(Integer.parseInt(id));
        }
        throw new RuntimeException("no dude, just no!");
    }


    private static Bot getBot(Integer botId) {
        if (!botMap.containsKey(botId)) {
            botMap.put(botId, new Bot(botId));
        }
        return botMap.get(botId);
    }

    private static Output getOutput(Integer outputId) {
        if (!outputMap.containsKey(outputId)) {
            outputMap.put(outputId, new Output(outputId));
        }
        return outputMap.get(outputId);
    }

}
