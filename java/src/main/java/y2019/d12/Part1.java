package y2019.d12;

import java.util.ArrayList;

public class Part1 {

    public static void main(String[] args) {
        ArrayList<Moon> moons = demoMoons1();



    }

    private static ArrayList<Moon> demoMoons1() {
        ArrayList<Moon> moons = new ArrayList<>(4);
        moons.add(new Moon(-1,  0,  2));
        moons.add(new Moon( 2, 10, -7));
        moons.add(new Moon( 4,  8,  8));
        moons.add(new Moon( 3,  5, -1));
        return moons;
    }

    private static ArrayList<Moon> demoMoons2() {
        ArrayList<Moon> moons = new ArrayList<>(4);
        moons.add(new Moon(-8, -10,  0));
        moons.add(new Moon( 5,   5, 10));
        moons.add(new Moon( 2,  -7,  3));
        moons.add(new Moon( 9,  -8, -3));
        return moons;
    }

    private static ArrayList<Moon> realMoons() {
        ArrayList<Moon> moons = new ArrayList<>(4);
        moons.add(new Moon(-4,   3, 15));
        moons.add(new Moon(11, -10, 13));
        moons.add(new Moon( 2,   2, 18));
        moons.add(new Moon( 7,  -1,  0));
        return moons;
    }

    private static class Moon {
        int posX;
        int posY;
        int posZ;

        int vX = 0;
        int vY = 0;
        int vZ = 0;

        public Moon(int posX, int posY, int posZ) {
            this.posX = posX;
            this.posY = posY;
            this.posZ = posZ;
        }

        public int getPosX() {
            return posX;
        }

        public int getPosY() {
            return posY;
        }

        public int getPosZ() {
            return posZ;
        }

        public void gravity(Moon otherMoon) {
            if (this.posX > otherMoon.getPosX()) {
                --this.vX;
            } else if (this.posX < otherMoon.getPosX()) {
                ++this.vX;
            }
        }

        public void tick() {
            this.posX += this.vX;
            this.posY += this.vY;
            this.posZ += this.vZ;
        }
    }
}
