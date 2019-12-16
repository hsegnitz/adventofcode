package y2019.d12;

import common.AocMath;

import java.util.ArrayList;

public class Part2 {

    public static void main(String[] args) {
        ArrayList<Moon> moons = realMoons();

        String seqX = extractState(moons, 'x');
        String seqY = extractState(moons, 'y');
        String seqZ = extractState(moons, 'z');

        int foundX = -1;
        int foundY = -1;
        int foundZ = -1;

        for (int i = 1; i < Integer.MAX_VALUE; i++) {
            for (int a = 0; a < 4; a++) {
                for (int b = 0; b < 4; b++) {
                    if (a == b) {
                        continue;
                    }
                    moons.get(a).gravity(moons.get(b));
                }
            }

            for (int a = 0; a < 4; a++) {
                moons.get(a).tick();
            }

            if (foundX < 0 && seqX.equals(extractState(moons, 'x'))) {
                System.out.println("x " + i);
                foundX = i;
            }

            if (foundY < 0 && seqY.equals(extractState(moons, 'y'))) {
                System.out.println("y " + i);
                foundY = i;
            }

            if (foundZ < 0 && seqZ.equals(extractState(moons, 'z'))) {
                System.out.println("z " + i);
                foundZ = i;
            }

            if (foundX > 0 && foundY > 0 && foundZ > 0) {
                break;
            }
        }

        System.out.println("alignment: " + leastCommonMultiple(foundX, foundY, foundZ));

    }

    private static long leastCommonMultiple(int x, int y, int z) {
        long lcm = x;
        lcm = (lcm * y) / AocMath.greatestCommonDivisor(lcm, y);
        lcm = (lcm * z) / AocMath.greatestCommonDivisor(lcm, z);
        return lcm;
    }

    private static String extractState(ArrayList<Moon> moons, char dimension) {
        StringBuilder state = new StringBuilder();

        for (int a = 0; a < 4; a++) {
            switch (dimension) {
                case 'x':
                    state.append(moons.get(a).getPosX())
                            .append(":")
                            .append(moons.get(a).vX);
                    break;
                case 'y':
                    state.append(moons.get(a).getPosY())
                            .append(":")
                            .append(moons.get(a).vY);
                    break;
                case 'z':
                    state.append(moons.get(a).getPosZ())
                            .append(":")
                            .append(moons.get(a).vZ);
                    break;
            }
            state.append("x");
        }


        return state.toString();
    }


    private static ArrayList<Moon> demoMoons1() {
        ArrayList<Moon> moons = new ArrayList<>(4);
        moons.add(new Moon(-1,   0,  2));
        moons.add(new Moon( 2, -10, -7));
        moons.add(new Moon( 4,  -8,  8));
        moons.add(new Moon( 3,   5, -1));
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
        moons.add(new Moon( -4,   3, 15));
        moons.add(new Moon(-11, -10, 13));
        moons.add(new Moon(  2,   2, 18));
        moons.add(new Moon(  7,  -1,  0));
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

            if (this.posY > otherMoon.getPosY()) {
                --this.vY;
            } else if (this.posY < otherMoon.getPosY()) {
                ++this.vY;
            }

            if (this.posZ > otherMoon.getPosZ()) {
                --this.vZ;
            } else if (this.posZ < otherMoon.getPosZ()) {
                ++this.vZ;
            }
        }

        public void tick() {
            this.posX += this.vX;
            this.posY += this.vY;
            this.posZ += this.vZ;
        }

        public int getPotential() {
            return Math.abs(this.posX) + Math.abs(this.posY) + Math.abs(this.posZ);
        }

        public int getKineticEnergy() {
            return Math.abs(this.vX) + Math.abs(this.vY) + Math.abs(this.vZ);
        }

        public int getTotalEnergy() {
            return this.getKineticEnergy() * this.getPotential();
        }

        public String toString() {
            return "coord(" + this.posX + "," + this.posY + "," + this.posZ + ") vel(" + this.vX + "," + this.vY + "," + this.vZ + ") " + this.getPotential();
        }
    }
}
