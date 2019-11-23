package y2016.d04;

import common.Files;
import org.apache.commons.codec.binary.StringUtils;
import org.jetbrains.annotations.NotNull;

import java.io.FileNotFoundException;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Part1 {

    private static class Letter implements Comparator<Letter>, Comparable<Letter> {
        private Character character;
        private int count;

        public Letter(Character character, int count) {
            this.character = character;
            this.count = count;
        }

        public Character getCharacter() {
            return character;
        }

        public int getCount() {
            return count;
        }

        @Override
        public int compareTo(@NotNull Part1.Letter o) {
            return compare(this, o);
        }

        @Override
        public int compare(Letter o1, Letter o2) {
            int countDifference = o2.getCount() - o1.getCount();

            if (countDifference != 0) {
                return countDifference;
            }

            return o1.getCharacter().compareTo(o2.getCharacter());
        }
    }

    private static class Room {
        private String name;
        private Integer sectorId;
        private String checksum;

        public Room(String raw) {
            Pattern pattern = Pattern.compile("^([a-z-]+)-(\\d+)\\[([a-z]+)]$");
            Matcher matcher = pattern.matcher(raw.trim());
            if (matcher.find()) {
                this.name = matcher.group(1).replace("-", "");
                this.sectorId = Integer.parseInt(matcher.group(2));
                this.checksum = matcher.group(3);
            }
        }

        public boolean isValid() {
            HashMap<Character, Integer> letters = new HashMap<>();

            for (int i = 0; i < name.length(); i++) {
                char c = name.charAt(i);
                if (letters.containsKey(c)) {
                    letters.put(c, letters.get(c) + 1);
                } else {
                    letters.put(c, 1);
                }
            }

            TreeSet<Letter> toBeSorted = new TreeSet<Letter>(new Letter('a', 0));
            for (Map.Entry<Character, Integer> entry: letters.entrySet()) {
                toBeSorted.add(new Letter(entry.getKey(), entry.getValue()));
            }

            int i = 0;
            for (Letter l: toBeSorted) {
                if (this.checksum.charAt(i++) != l.getCharacter()) {
                    return false;
                }
                if (i >= 5) {
                    return true;
                }
            }
            return false;
        }

        public Integer getSectorId(){
            return sectorId;
        }

        public String toString() {
            return this.name + " - " + this.sectorId + " - " + this.checksum;
        }
    }


    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> lines = Files.readByLines("src/main/java/y2016/d04/in.txt");

        Integer sum = 0;
        for (String line: lines) {
            Room room = new Room(line);
            if (room.isValid()) {
                sum += room.getSectorId();
            }
        }

        System.out.println(sum);
    }

}
