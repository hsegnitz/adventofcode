<?php

class party
{
    private $name;
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
}

class group
{
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

}

function parseGroups(party $party, $linesRaw)
{
    $pattern = '/^(\d+) units each with (\d+) hit points (\((.*)\) )?with an attack that does (\d+) (\w+) damage at initiative (\d+)$/';
    $subpattern = '/(weak|immune) to ([^;]+)/';

    $lines = explode("\n", $linesRaw);
    array_shift($lines);

    foreach ($lines as $line) {
        if (trim($line) === '') {
            continue;
        }
        $group = new group();

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


$in = file_get_contents('small.txt');
$split = explode("\n\n", $in);

$immune    = new party('immune');
$infection = new party('infection');

parseGroups($immune,    $split[0]);
parseGroups($infection, $split[1]);

