package y2015.d19;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.*;

public class Part1 {

    private static class Replacement {
        String from;
        String to;

        public Replacement(String from, String to) {
            this.from = from;
            this.to = to;
        }

        public String getFrom() {
            return from;
        }

        public String getTo() {
            return to;
        }
    }

    private static HashSet<String> permutations = new HashSet<>();
    private static String molecule;

    public static void main(String[] args) throws FileNotFoundException {
        List<Replacement> replacements = getReplacements();

        for (Replacement rep: replacements) {
            permutate(rep, molecule);
        }

        System.out.println(permutations.size());
    }

    private static void permutate (Replacement replacement, String molecule) {
        String[] splt = molecule.split(replacement.getFrom());
        ArrayList<String> split = new ArrayList<>(Arrays.asList(splt));

        if (molecule.substring(molecule.length() - replacement.getFrom().length()).equals(replacement.getFrom())) {
            split.add("");
        }

        for (int i = 1; i < split.size(); i++) {
            List<String> left  = split.subList(0 , i);
            List<String> right = split.subList(i, split.size());

            String out = String.join(replacement.getFrom(), left.toArray(new String[0]))
                    + replacement.getTo()
                    + String.join(replacement.getFrom(), right.toArray(new String[0]));

            permutations.add(out);
        }
    }

    private static List<Replacement> getReplacements () throws FileNotFoundException {
        File file = new File("src/main/java/y2015/d19/in.txt");
        Scanner scanner = new Scanner(file);

        List<Replacement> replacements = new ArrayList<>();
        String rawLine = "";
        while (scanner.hasNextLine()) {
            rawLine = scanner.nextLine();
            String[] split = rawLine.split(" ");
            if (split.length == 3) {
                replacements.add(
                        new Replacement(split[0], split[2])
                );
            } else if (split.length == 1 && rawLine.length() > 5) {
                molecule = rawLine;
            }
        }

        return replacements;
    }

}
