package y2015.d19;

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

    public static void main(String[] args) {
        String molecule = "HOH";
        Replacement[] replacements = getReplacements();

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



    private static Replacement[] getReplacements () {
        return new Replacement[]{
                new Replacement("H", "HO"),
                new Replacement("H", "OH"),
                new Replacement("O", "HH"),
        };
    }

}
