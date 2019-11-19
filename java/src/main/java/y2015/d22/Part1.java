package y2015.d22;

import java.util.concurrent.ThreadLocalRandom;

public class Part1 {

    private static int leastManaSpent  = Integer.MAX_VALUE;
    private static int mana;
    private static int hitPointsPlayer;
    private static int bossDamage;
    private static int hitPointsBoss;

    private static int shieldDurationLeft;
    private static int poisonDurationLeft;
    private static int rechargeDurationLeft;

    private static int manaSpent;
    private static boolean playerTurn;

    private static void reset() {
        mana            = 500;
        hitPointsPlayer =  50;
        bossDamage      =   8;
        hitPointsBoss   =  55;

        shieldDurationLeft   = 0;
        poisonDurationLeft   = 0;
        rechargeDurationLeft = 0;

        manaSpent  = 0;
        playerTurn = true;
    }

    public static void main(String[] args) {

        while (true) {
            reset();
            
            while (true) {

                if (!playerTurn) {
                    handleStatusEffects();
                    if (hitPointsBoss <= 0) {
                        registerWin();
                        break;
                    }

                    bossAttack();
                    if (hitPointsPlayer <= 0) {
                        // lost == reset is happening automatically
                        break;
                    }

                    playerTurn = true;
                    continue;
                }
                playerTurn = false;

                --hitPointsPlayer;
                if (hitPointsPlayer <= 0) {
                    // lost because of "hard" setting -- day 2
                    break;
                }

                handleStatusEffects();
                if (hitPointsBoss <= 0) {
                    registerWin();
                    break;
                }

                // determine next spell to cast but skip the ones already running
                int random = -1;
                while (random < 0) {
                    random = ThreadLocalRandom.current().nextInt(0, 5);
                    if ((random == 2 && shieldDurationLeft > 0)
                            || (random == 3 && poisonDurationLeft > 0)
                            || (random == 4 && rechargeDurationLeft > 0)
                    ) {
                        random = -1;
                    }
                }

                if (random == 0) { // magic missile
                    mana -= 53;
                    manaSpent += 53;
                    hitPointsBoss -= 4;
                }

                if (random == 1) { // drain
                    mana -= 73;
                    manaSpent += 73;
                    hitPointsBoss -= 2;
                    hitPointsPlayer += 2;
                }

                if (random == 2) {
                    shieldDurationLeft = 6;
                    mana -= 113;
                    manaSpent += 113;
                }

                if (random == 3) {
                    poisonDurationLeft = 6;
                    mana -= 173;
                    manaSpent += 173;
                }

                if (random == 4) {
                    rechargeDurationLeft = 5;
                    mana -= 229;
                    manaSpent += 229;
                }

                // suuuuper lazy check: if overspent on mana, just retry the whole game ;)
                if (mana <= 0) {
                    break;
                }

                if (hitPointsBoss <= 0) {
                    registerWin();
                    break;
                }
            }
        }
    }

    private static void registerWin() {
        if (manaSpent < leastManaSpent) {
            leastManaSpent = manaSpent;
        }
        System.out.println("won and mana spent: " + manaSpent + "; leastAmountSoFar: " + leastManaSpent);
    }

    private static void handleStatusEffects() {
        if (poisonDurationLeft > 0) {
            hitPointsBoss -= 3;
            poisonDurationLeft--;
        }
        if (rechargeDurationLeft > 0) {
            mana += 101;
            rechargeDurationLeft--;
        }
        if (shieldDurationLeft > 0) {
            shieldDurationLeft--;
        }
    }

    private static void bossAttack() {
        int damage = bossDamage;

        if (shieldDurationLeft > 0) {
            damage -= 7;
        }
        hitPointsPlayer -= Math.max(1, damage);
    }
}
