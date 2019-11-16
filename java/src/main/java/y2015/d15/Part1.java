package y2015.d15;

public class Part1 {

    public static void main(String[] args) {
        int best = Integer.MIN_VALUE;
        for (int sprinkles = 0; sprinkles <= 100; sprinkles++) {
            for (int peanutButter = 0; peanutButter <= (100 - sprinkles); peanutButter++) {
                for (int frosting = 0; frosting <= (100 - sprinkles - peanutButter); frosting++) {
                    int sugar = 100 - sprinkles - peanutButter - frosting;
                    try {
                        Recipe r = new Recipe(sprinkles, peanutButter, frosting, sugar);
                        if (r.getCalories() != 500) {
                            continue;
                        }
                        best = Math.max(r.getScore(), best);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
                }
            }
        }

        System.out.println("Best: " + best);
    }
}
