package y2015.d15;

public class IngredientFactory {

    public static Ingredient getSprinkles() {
        return new Ingredient(5, -1, 0, 0, 5);
    }

    public static Ingredient getPeanutButter() {
        return new Ingredient(-1, 3, 0, 0, 1);
    }

    public static Ingredient getFrosting() {
        return new Ingredient(0, -1, 4, 0, 6);
    }

    public static Ingredient getSugar() {
        return new Ingredient(-1, 0, 0, 2, 8);
    }

}
