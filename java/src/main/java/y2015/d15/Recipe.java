package y2015.d15;

public class Recipe {

    private int sprinkleCount;
    private int peanutButterCount;
    private int frostingCount;
    private int sugarCount;

    Ingredient sprinkles    = IngredientFactory.getSprinkles();
    Ingredient peanutButter = IngredientFactory.getPeanutButter();
    Ingredient frosting     = IngredientFactory.getFrosting();
    Ingredient sugar        = IngredientFactory.getSugar();

    public Recipe(int sprinkleCount, int peanutButterCount, int frostingCount, int sugarCount) throws Exception {
        if (sprinkleCount + peanutButterCount + frostingCount + sugarCount != 100) {
            throw new Exception("invalid recipe");
        }

        this.sprinkleCount = sprinkleCount;
        this.peanutButterCount = peanutButterCount;
        this.frostingCount = frostingCount;
        this.sugarCount = sugarCount;
    }

    public int getScore() {
        int capacity = (this.sprinkleCount * sprinkles.getCapacity())
                + (this.peanutButterCount * peanutButter.getCapacity())
                + (this.frostingCount * frosting.getCapacity())
                + (this.sugarCount * sugar.getCapacity());
        int durability = (this.sprinkleCount * sprinkles.getDurability())
                + (this.peanutButterCount * peanutButter.getDurability())
                + (this.frostingCount * frosting.getDurability())
                + (this.sugarCount * sugar.getDurability());
        int flavor = (this.sprinkleCount * sprinkles.getFlavor())
                + (this.peanutButterCount * peanutButter.getFlavor())
                + (this.frostingCount * frosting.getFlavor())
                + (this.sugarCount * sugar.getFlavor());
        int texture = (this.sprinkleCount * sprinkles.getTexture())
                + (this.peanutButterCount * peanutButter.getTexture())
                + (this.frostingCount * frosting.getTexture())
                + (this.sugarCount * sugar.getTexture());

        if (capacity < 0 || durability < 0 || flavor < 0 || texture < 0) {
            return 0;
        }

        return capacity * durability * flavor * texture;
    }

    public int getCalories() {
        return (this.sprinkleCount * sprinkles.getCalories())
                + (this.peanutButterCount * peanutButter.getCalories())
                + (this.frostingCount * frosting.getCalories())
                + (this.sugarCount * sugar.getCalories());
    }

}
