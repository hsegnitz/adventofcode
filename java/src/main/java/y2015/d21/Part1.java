package y2015.d21;

import java.security.InvalidParameterException;

public class Part1 {

    private static class Player {
        private int hitpoints;
        private int baseDamage = 0;
        private int baseArmor  = 0;

        private Weapon weapon;
        private Armor  armor;
        private Ring   ringLeft;
        private Ring   ringRight;

        public Player(int hitpoints) {
            this.hitpoints = hitpoints;
        }

        public Player(int hitpoints, int baseDamage, int baseArmor) {
            this.hitpoints = hitpoints;
            this.baseDamage = baseDamage;
            this.baseArmor = baseArmor;
        }

        public int getDamage() {
            int damage = baseDamage;

            if (this.weapon != null) {
                damage += this.weapon.getDamage();
            }
            if (this.ringLeft != null) {
                damage += this.ringLeft.getDamage();
            }
            if (this.ringRight != null) {
                damage += this.ringRight.getDamage();
            }

            return damage;
        }

        public int getArmor() {
            int armor = baseArmor;

            if (this.armor != null) {
                armor += this.armor.getArmor();
            }
            if (this.ringLeft != null) {
                armor += this.ringLeft.getArmor();
            }
            if (this.ringRight != null) {
                armor += this.ringRight.getArmor();
            }

            return armor;
        }

        public int getCost() {
            int cost = 0;
            if (this.weapon != null) {
                cost += this.weapon.getCost();
            }
            if (this.armor != null) {
                cost += this.armor.getCost();
            }
            if (this.ringLeft != null) {
                cost += this.ringLeft.getCost();
            }
            if (this.ringRight != null) {
                cost += this.ringRight.getCost();
            }
            return cost;
        }

        public void equip(Item item) {
            if (item instanceof Weapon && null == this.weapon) {
                this.weapon = (Weapon)item;
                return;
            } else if (item instanceof Armor && null == this.armor) {
                this.armor = (Armor)item;
                return;
            } else if (item instanceof Ring) {
                if (null == this.ringLeft) {
                    this.ringLeft = (Ring)item;
                    return;
                } else if (null == this.ringRight) {
                    this.ringRight = (Ring)item;
                    return;
                }
            }
            throw new InvalidParameterException("we're full!");
        }

        public boolean hasRing(Ring ring) {
            return (this.ringRight != null && this.ringRight.getName().equals(ring.getName()))
                    || (this.ringLeft != null && this.ringLeft.getName().equals(ring.getName()));
        }

        public boolean hitByAndIsDead(Player opponent) {
            int damage = opponent.getDamage() - this.getArmor();
            if (damage < 1) {
                damage = 1;
            }

            this.hitpoints -= damage;

            if (hitpoints <= 0) {
                return true;
            }
            return false;
        }

    }

    private static abstract class Item {
        String name;
        int cost;
        int damage;
        int armor;

        public Item(String name, int cost, int damage, int armor) {
            this.name = name;
            this.cost = cost;
            this.damage = damage;
            this.armor = armor;
        }

        public String getName() {
            return name;
        }

        public int getCost() {
            return cost;
        }

        public int getDamage() {
            return damage;
        }

        public int getArmor() {
            return armor;
        }
    }

    private static class Weapon extends Item {
        public Weapon(String name, int cost, int damage) {
            super(name, cost, damage, 0);
        }
    }

    private static class Armor extends Item {
        public Armor(String name, int cost, int armor) {
            super(name, cost, 0, armor);
        }
    }

    private static class Ring extends Item {
        public Ring(String name, int cost, int damage, int armor) {
            super(name, cost, damage, armor);
        }
    }

    private static class Store {
        private static Weapon[] weapons = new Weapon[]{
                new Weapon("Dagger",      8, 4),
                new Weapon("Shortsword", 10, 5),
                new Weapon("Warhammer",  25, 6),
                new Weapon("Longsword",  40, 7),
                new Weapon("Greataxe",   74, 8),
        };

        private static Armor[] armors = new Armor[]{
                new Armor("NullArmor",    0, 0),
                new Armor("Leather",     13, 1),
                new Armor("Chainmail",   31, 2),
                new Armor("Splintmail",  53, 3),
                new Armor("Bandedmail",  75, 4),
                new Armor("Platemail",  102, 5),
        };

        private static Ring[] rings = new Ring[]{
                new Ring("Damage +0",    0, 0, 0),
                new Ring("Damage +1",   25, 1, 0),
                new Ring("Damage +2",   50, 2, 0),
                new Ring("Damage +3",  100, 3, 0),
                new Ring("Defense +0",   0, 0, 0),
                new Ring("Defense +1",  20, 0, 1),
                new Ring("Defense +2",  40, 0, 2),
                new Ring("Defense +3",  80, 0, 3),
        };

        public static Weapon[] getWeapons() {
            return weapons;
        }

        public static Armor[] getArmors() {
            return armors;
        }

        public static Ring[] getRings() {
            return rings;
        }
    }


    public static void main(String[] args) {
        int minCost = Integer.MAX_VALUE;

        for (Weapon weapon: Store.getWeapons()) {
            for (Armor armor: Store.getArmors()) {
                for (Ring ringLeft: Store.getRings()) {
                    for (Ring ringRight: Store.getRings()) {
                        Player boss   = new Player(109, 8, 2);
                        Player player = new Player(100);
                        player.equip(weapon);
                        player.equip(armor);
                        player.equip(ringLeft);
                        if (player.hasRing(ringRight)) {
                            continue; // skip same ring twice!
                        }
                        player.equip(ringRight);

                        if (player.getCost() < minCost && isPlayerVictorious(boss, player)) {
                            minCost = Math.min(minCost, player.getCost());
                        }
                    }
                }
            }
        }

        System.out.println("min Gold to win:" + minCost);
    }

    public static boolean isPlayerVictorious(Player boss, Player player) {
        while (true) {
            if (boss.hitByAndIsDead(player)) {
                return true;
            }
            if (player.hitByAndIsDead(boss)) {
                return false;
            }
        }
    }
}
