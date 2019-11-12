package y2015.d16;

public class Sue {
    private int number      = -1;
    private int children    = -1;
    private int cats        = -1;
    private int samoyeds    = -1;
    private int pomeranians = -1;
    private int akitas      = -1;
    private int vizslas     = -1;
    private int goldfish    = -1;
    private int trees       = -1;
    private int cars        = -1;
    private int perfumes    = -1;

    public Sue (int number) {
        this.number = number;
    }

    public void setValue (String key, int value) throws Exception {
        switch (key) {
            case "children":    this.children    = value; break;
            case "cats":        this.cats        = value; break;
            case "samoyeds":    this.samoyeds    = value; break;
            case "pomeranians": this.pomeranians = value; break;
            case "akitas":      this.akitas      = value; break;
            case "vizslas":     this.vizslas     = value; break;
            case "goldfish":    this.goldfish    = value; break;
            case "trees":       this.trees       = value; break;
            case "cars":        this.cars        = value; break;
            case "perfumes":    this.perfumes    = value; break;
            default: throw new Exception("unknown value");
        }
    }

    public int getNumber() {
        return this.number;
    }

    public boolean equals(Sue sue) {
        if (this.children != -1 && sue.children != -1 && this.children != sue.children) {
            return false;
        }
        if (this.cats != -1 && sue.cats != -1 && this.cats != sue.cats) {
            return false;
        }
        if (this.samoyeds != -1 && sue.samoyeds != -1 && this.samoyeds != sue.samoyeds) {
            return false;
        }
        if (this.pomeranians != -1 && sue.pomeranians != -1 && this.pomeranians != sue.pomeranians) {
            return false;
        }
        if (this.akitas != -1 && sue.akitas != -1 && this.akitas != sue.akitas) {
            return false;
        }
        if (this.vizslas != -1 && sue.vizslas != -1 && this.vizslas != sue.vizslas) {
            return false;
        }
        if (this.goldfish != -1 && sue.goldfish != -1 && this.goldfish != sue.goldfish) {
            return false;
        }
        if (this.trees != -1 && sue.trees != -1 && this.trees != sue.trees) {
            return false;
        }
        if (this.cars != -1 && sue.cars != -1 && this.cars != sue.cars) {
            return false;
        }
        if (this.perfumes != -1 && sue.perfumes != -1 && this.perfumes != sue.perfumes) {
            return false;
        }
        return true;
    }
}
