<?php

class EffectivenessHeap extends SplMaxHeap
{
    /**
     * @param  group $a
     * @param  group $b
     * @return int
     */
    public function compare($a, $b)
    {
        if ($a->getEffectivePower() > $b->getEffectivePower()) {
            return 1;
        }
        if ($a->getEffectivePower() < $b->getEffectivePower()) {
            return -1;
        }

        if ($a->getInitiative() > $b->getInitiative()) {
            return 1;
        }
        if ($a->getInitiative() < $b->getInitiative()) {
            return -1;
        }

        return 0;
    }
}

class InitiativeHeap extends SplMaxHeap
{
    /**
     * @param  group $a
     * @param  group $b
     * @return int
     */
    public function compare($a, $b)
    {
        if ($a->getInitiative() > $b->getInitiative()) {
            return 1;
        }
        if ($a->getInitiative() < $b->getInitiative()) {
            return -1;
        }
        return 0;
    }
}


class party
{
    private $name;
    /** @var group[] */
    private $groups = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addGroup(group $group)
    {
        $this->groups[] = $group;
    }

    /**
     * @return group[]
     */
    public function getGroups()
    {
        $newGroups = [];
        foreach ($this->groups as $group) {
            if ($group->getUnits() > 0) {
                $newGroups[] = $group;
            }
        }

        $this->groups = $newGroups;

        return $this->groups;
    }

    /**
     * @return int
     */
    public function getUnitCount()
    {
        $count = 0;
        foreach ($this->getGroups() as $group) {
            $count += $group->getUnits();
        }
        return $count;
    }
}

class group
{
    public static $instanceCount = 0;

    /** @var int */
    private $id;

    /** @var int */
    private $units       = 0;

    /** @var int */
    private $hitpoints   = 0;

    /** @var array */
    private $immunities  = [];

    /** @var array */
    private $weaknesses  = [];

    /** @var int */
    private $strength    = 0;

    /** @var string */
    private $attacktype  = '';

    /** @var int */
    private $initiative  = 0;

    /** @var group */
    private $target = null;

    public function __construct($party)
    {
        $this->id = $party . '_' . ++self::$instanceCount;
    }

    public function getId()
    {
    return $this->id;
    }

    /**
     * @return int
     */
    public function getUnits(): int
    {
        return $this->units;
    }

    /**
     * @param int $units
     */
    public function setUnits(int $units): void
    {
        $this->units = $units;
    }

    /**
     * @return int
     */
    public function getHitpoints(): int
    {
        return $this->hitpoints;
    }

    /**
     * @param int $hitpoints
     */
    public function setHitpoints(int $hitpoints): void
    {
        $this->hitpoints = $hitpoints;
    }

    /**
     * @return array
     */
    public function getImmunities(): array
    {
        return $this->immunities;
    }

    /**
     * @param array $immunities
     */
    public function setImmunities(array $immunities): void
    {
        $this->immunities = $immunities;
    }

    /**
     * @return array
     */
    public function getWeaknesses(): array
    {
        return $this->weaknesses;
    }

    /**
     * @param array $weaknesses
     */
    public function setWeaknesses(array $weaknesses): void
    {
        $this->weaknesses = $weaknesses;
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @param int $strength
     */
    public function setStrength(int $strength): void
    {
        $this->strength = $strength;
    }

    /**
     * @return string
     */
    public function getAttacktype(): string
    {
        return $this->attacktype;
    }

    /**
     * @param string $attacktype
     */
    public function setAttacktype(string $attacktype): void
    {
        $this->attacktype = $attacktype;
    }

    /**
     * @return int
     */
    public function getInitiative(): int
    {
        return $this->initiative;
    }

    /**
     * @param int $initiative
     */
    public function setInitiative(int $initiative): void
    {
        $this->initiative = $initiative;
    }

    /**
     * @return int
     */
    public function getEffectivePower()
    {
        return $this->units * $this->strength;
    }

    /**
     * @param  group[] $groups
     * @return group[] $groups minus the chosen one -- if chosen
     */
    public function chooseTarget($groups)
    {
        $this->target = null;
        if ($groups === []) {
            return [];
        }

        $attacker = $this;
        usort($groups, function ($a, $b) use ($attacker) {
            $damageDelta = $attacker->damageAgainst($b) - $attacker->damageAgainst($a);
            if ($damageDelta != 0) {
                return $damageDelta;
            }

            $effectiveDelta = $a->getEffectivePower() - $b->getEffectivePower();
            if ($effectiveDelta !== 0) {
                return $effectiveDelta;
            }

            return $a->getInitiative() - $b->getInitiative();
        });

        echo '  ', $attacker->getId(), ' damage against ';
        foreach ($groups as $group) {
            echo $group->getId(), '(', $attacker->damageAgainst($group), '|', $group->getEffectivePower(), '|', $group->getInitiative() , ') ';
        }
        echo "\n";
        $target = array_shift($groups);
        if ($this->damageAgainst($target) === 0) {
            array_unshift($groups, $target);
            return $groups;
        }

        $this->target = $target;
        return $groups;
    }

    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param  group $victim
     * @return int
     */
    public function damageAgainst(group $victim)
    {
        if (in_array($this->getAttacktype(), $victim->getImmunities())) {
            return 0;
        }

        if (in_array($this->getAttacktype(), $victim->getWeaknesses())) {
            return $this->getEffectivePower() * 2;
        }

        return $this->getEffectivePower();
    }

    /**
     * @return int
     */
    public function attack()
    {
        if ($this->units <= 0 || null === $this->target) {
            $this->target = null;
            return 0;
        }

        $killed = $this->target->receiveDamage($this->damageAgainst($this->target));
        $this->target = null;

        return $killed;
    }

    /**
     * @param int $damage
     * @return int
     */
    public function receiveDamage($damage)
    {
        $killed = floor($damage / $this->hitpoints);
        if ($this->units < $killed) {
            $killed = $this->units;
        }
        $this->units -= $killed;
        return $killed;
    }
}

/**
 * @param party $immune
 * @param party $infection
 */
function fight($immune, $infection)
{
    $heapInitiative = new InitiativeHeap();

    echo "\n";

    //// target selection
    /// immune
    // priority
    $heapSelection = new EffectivenessHeap();
    foreach ($immune->getGroups() as $immuneGroup) {
        $heapSelection->insert($immuneGroup);
    }

    // choosing
    $targets = $infection->getGroups();
    while ($heapSelection->valid()) {
        /** @var group $immuneGroup */
        $immuneGroup = $heapSelection->extract();
        echo $immuneGroup->getId(), '-', $immuneGroup->getEffectivePower(), '|';
        $targets = $immuneGroup->chooseTarget($targets);
        $heapInitiative->insert($immuneGroup);
    }

    /// infection
    // priority
    $heapSelection = new EffectivenessHeap();
    foreach ($infection->getGroups() as $infectionGroup) {
        $heapSelection->insert($infectionGroup);
    }

    // choosing
    $targets = $immune->getGroups();
    while ($heapSelection->valid()) {
        /** @var group $infectionGroup */
        $infectionGroup = $heapSelection->extract();
        echo $infectionGroup->getId(), '-', $infectionGroup->getEffectivePower(), '|';
        $targets = $infectionGroup->chooseTarget($targets);
        $heapInitiative->insert($infectionGroup);
    }

    echo "\n";
    foreach ($immune->getGroups() as $ig) {
        echo 'img (', $ig->getId(). ') chooses ifg (', ($ig->getTarget() instanceof group) ? $ig->getTarget()->getId() : 'nothing', ")\n";
    }

    foreach ($infection->getGroups() as $if) {
        echo 'ifg (', $if->getId(). ') chooses img (', ($if->getTarget() instanceof group) ? $if->getTarget()->getId() : 'nothing', ")\n";
    }

    echo "\n";

    //// fight
    while ($heapInitiative->valid()) {
        /** @var group $attacker */
        $attacker = $heapInitiative->extract();
        echo $attacker->getId(), ' with initiative ', $attacker->getInitiative(), ' attacks ', ($attacker->getTarget() instanceof group) ? $attacker->getTarget()->getId() : 'nothing';
        echo ' killing ';
        echo $attacker->attack();
        echo "\n";

    }
    #die();
}



function parseGroups(party $party, $linesRaw)
{
    $pattern = '/^(\d+) units each with (\d+) hit points (\((.*)\) )?with an attack that does (\d+) (\w+) damage at initiative (\d+)$/';
    $subpattern = '/(weak|immune) to ([^;]+)/';

    $lines = explode("\n", $linesRaw);
    array_shift($lines);

    group::$instanceCount = 0;

    foreach ($lines as $line) {
        if (trim($line) === '') {
            continue;
        }
        $group = new group($party->getName());

        $out = [];
        preg_match($pattern, $line, $out);

        $group->setUnits($out[1]);
        $group->setHitpoints($out[2]);
        $group->setStrength($out[5]);
        $group->setAttacktype($out[6]);
        $group->setInitiative($out[7]);

        $wiOut = [];
        if ($out[4] !== '') {
            preg_match_all($subpattern, $out[4], $wiOut);
            foreach ($wiOut[1] as $key => $type) {
                if ($type === 'weak') {
                    $group->setWeaknesses(explode(', ', $wiOut[2][$key]));
                }
                if ($type === 'immune') {
                    $group->setImmunities(explode(', ', $wiOut[2][$key]));
                }
            }
        }

        $party->addGroup($group);
    }
}


$in = file_get_contents('in.txt');
$split = explode("\n\n", $in);

$immune    = new party('immune');
$infection = new party('infection');

parseGroups($immune,    $split[0]);
parseGroups($infection, $split[1]);

/*
var_export($immune);
var_export($infection);
*/

echo 'immune: ', $immune->getUnitCount();
echo '   infect: ', $infection->getUnitCount(), "\n";

echo "\n\nlet's fight!\n\n";


while ($immune->getGroups() !== [] && $infection->getGroups() !== []) {
    fight($immune, $infection);
    echo 'immune: ', $immune->getUnitCount();
    echo '   infect: ', $infection->getUnitCount(), "\n";
}

echo "\n\nit's over!\n\n";
echo 'immune: ', $immune->getUnitCount();
echo '   infect: ', $infection->getUnitCount(), "\n";

