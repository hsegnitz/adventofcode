package y2016.d10;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    private static HashMap<Integer, Bot> BotMap = new HashMap<>();

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
                getBot(Integer.parseInt(m.group(1))).setHighBot(getBot(Integer.parseInt(m.group(3))));
                getBot(Integer.parseInt(m.group(1))).setLowBot(getBot(Integer.parseInt(m.group(2))));
            }

            System.out.println("NOTHING!!! " + line);
        }
    }


    private static Bot getBot(Integer botId) {
        if (!BotMap.containsKey(botId)) {
            BotMap.put(botId, new Bot(botId));
        }
        return BotMap.get(botId);
    }

}
