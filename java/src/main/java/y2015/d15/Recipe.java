package y2015.d15;

public class Recipe {

    private int sprinkles;
    private int peanutButter;
    private int frosting;
    private int sugar;

    public Recipe(int sprinkles, int peanutButter, int frosting, int sugar) throws Exception {
        if (sprinkles + peanutButter + frosting + sugar != 100) {
            throw new Exception("invalid recipe");
        }

        this.sprinkles    = sprinkles;
        this.peanutButter = peanutButter;
        this.frosting     = frosting;
        this.sugar        = sugar;
    }

    public int getScore() {
        Ingredient sprinkles    = IngredientFactory.getSprinkles();
        Ingredient peanutButter = IngredientFactory.getPeanutButter();
        Ingredient frosting     = IngredientFactory.getFrosting();
        Ingredient sugar        = IngredientFactory.getSugar();

        int capacity   = (this.sprinkles * sprinkles.getCapacity())
                + (this.peanutButter     * peanutButter.getCapacity())
                + (this.frosting         * frosting.getCapacity())
                + (this.sugar            * sugar.getCapacity());
        int durability = (this.sprinkles * sprinkles.getDurability())
                + (this.peanutButter     * peanutButter.getDurability())
                + (this.frosting         * frosting.getDurability())
                + (this.sugar            * sugar.getDurability());
        int flavor     = (this.sprinkles * sprinkles.getFlavor())
                + (this.peanutButter     * peanutButter.getFlavor())
                + (this.frosting         * frosting.getFlavor())
                + (this.sugar            * sugar.getFlavor());
        int texture    = (this.sprinkles * sprinkles.getTexture())
                + (this.peanutButter     * peanutButter.getTexture())
                + (this.frosting         * frosting.getTexture())
                + (this.sugar            * sugar.getTexture());

        if (capacity < 0 || durability < 0 || flavor < 0 || texture < 0) {
            return 0;
        }

        return capacity * durability * flavor * texture;
    }


}
