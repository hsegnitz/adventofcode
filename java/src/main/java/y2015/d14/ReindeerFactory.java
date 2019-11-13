package y2015.d14;

public class ReindeerFactory {

    public static Reindeer[] getReindeers() {
        return new Reindeer[]{
                new Reindeer("Vixen",    8,  8,  53),
                new Reindeer("Blitzen", 13,  4,  49),
                new Reindeer("Rudolph", 20,  7, 132),
                new Reindeer("Cupid",   12,  4,  43),
                new Reindeer("Donner",   9,  5,  38),
                new Reindeer("Dasher",  10,  4,  37),
                new Reindeer("Comet",    3, 37,  76),
                new Reindeer("Prancer",  9, 12,  97),
                new Reindeer("Dancer",  37,  1,  36)
        };
    }

    public static Reindeer[] getDemoReindeers() {
        return new Reindeer[]{
                new Reindeer("Comet",  14, 10, 127),
                new Reindeer("Dancer", 16, 11, 162)
        };
    }
}
