package y2019.d06;

import common.Files;

import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;

public class Part1 {

    private static class SpaceObject {
        private String name;
        private SpaceObject parent;
        private HashSet<SpaceObject> children = new HashSet<>();

        public SpaceObject(String name) {
            this.name = name;
        }

        public void addChild(SpaceObject child) {
            children.add(child);
            child.setParent(this);
        }

        public void setParent(SpaceObject parent) {
            this.parent = parent;
        }

        public int countParents() {
            if (null != this.parent) {
                return 1 + this.parent.countParents();
            }
            return 0;
        }

        public String getName() {
            return name;
        }

        public SpaceObject getParent() {
            return parent;
        }

        public boolean countTowardsCommonAncestor(String searchFor) {
            if (children.isEmpty()) {
                return false;
            }

            for (SpaceObject child: children) {
                if (child.getName().equals(searchFor)) {
                    return true;
                }
                if (child.countTowardsCommonAncestor(searchFor)) {
                    return true;
                }
            }

            return false;
        }
    }

    private static HashMap<String, SpaceObject> space = new HashMap<>();

    public static void main(String[] args) throws FileNotFoundException {
        ArrayList<String> input = Files.readByLines("src/main/java/y2019/d06/in.txt");

        SpaceObject com = new SpaceObject("COM");
        space.put("COM", com);

        Boolean allFound = false;
        while (allFound == false) {
            allFound = true;
            for (String line: input) {
                String[] split = line.split("\\)");
                if (space.containsKey(split[1])) {
                    continue;
                }
                if (space.containsKey(split[0])) {
                    SpaceObject so = new SpaceObject(split[1]);
                    space.put(split[1], so);
                    space.get(split[0]).addChild(so);
                } else {
                    allFound = false;
                }
            }
        }

        int sum = 0;
        for (SpaceObject so: space.values()) {
            sum += so.countParents();
        }

        System.out.println(sum);

        SpaceObject me = space.get("YOU");
        outputParentChain(me);

        SpaceObject santa = space.get("SAN");
        outputParentChain(santa);

        // manually for speed: delete YOU and SAN from the strings, then all the common steps and then count the commas (divide length by 4)
        // @todo: do that programmatically
        // @todo2: use another recursive function to do the actual counting... ;)
    }

    public static void outputParentChain(SpaceObject child) {
        SpaceObject cur = child;
        StringBuilder out = new StringBuilder();
        while(!cur.getName().equals("COM")) {
            out.insert(0, cur.getName() + ",");
            cur = cur.getParent();
        }
        out.insert(0, "COM,");
        System.out.println(out);
    }
}
