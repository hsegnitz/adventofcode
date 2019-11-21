package y2015.d19;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.*;

public class Part2 {

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

    private static String molecule;

    public static void main(String[] args) throws FileNotFoundException {
        List<Replacement> replacements = getReplacements();
        String localMolecule = molecule;

        int count = 0;
        while ((count = solve(0, localMolecule, replacements)) == -1);

        System.out.println(count);
    }

    private static int solve(int depth, String localMolecule, List<Replacement> replacements) {

        if (localMolecule.equals("e")) {
            return depth;
        } else {
            List<Replacement> reps = new ArrayList<>(replacements);
            boolean found = false;
            while (!found) {
                Replacement rep = reps.remove(new Random().nextInt(reps.size()));
                if (localMolecule.contains(rep.getTo())) {
                    localMolecule = replace(localMolecule, rep.getTo(), rep.getFrom(), localMolecule.indexOf(rep.getTo()));
                    found = true;
                }

                if (reps.size() == 0) {
                    return -1;
                }
            }

            return solve(depth+1, localMolecule, replacements);
        }
    }

    public static String replace(String haystack, String search, String replace, int position) {
        return haystack.substring(0, position) + replace + haystack.substring(position + search.length());
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
