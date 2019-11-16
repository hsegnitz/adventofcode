package y2015.d15;

public class Ingredient {

    private int capacity;
    private int durability;
    private int flavor;
    private int texture;
    private int calories;

    public Ingredient(int capacity, int durability, int flavor, int texture, int calories) {
        this.capacity = capacity;
        this.durability = durability;
        this.flavor = flavor;
        this.texture = texture;
        this.calories = calories;
    }

    public int getCapacity() {
        return capacity;
    }

    public int getDurability() {
        return durability;
    }

    public int getFlavor() {
        return flavor;
    }

    public int getTexture() {
        return texture;
    }

    public int getCalories() {
        return calories;
    }
}
