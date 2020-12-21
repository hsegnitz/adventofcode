<?php

$startTime = microtime(true);

class Program {
    /** @var Program[] */
    private $children = [];
    private $weight;
    private $name;

    /** @var Program */
    private $parent;

    public function __construct(string $name, int $weight)
    {
        $this->name   = $name;
        $this->weight = $weight;
    }

    // this is total, including children!
    public function getTotalWeight(): int
    {
        $weight = $this->weight;
        foreach ($this->children as $child) {
            $weight += $child->getTotalWeight();
        }
        return $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): Program
    {
        return $this->parent;
    }

    public function setParent(Program $parent): void
    {
        $this->parent = $parent;
    }

    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    public function addChild(Program $child): void
    {
        $child->setParent($this);
        $this->children[$child->getName()] = $child;
    }

    public function isStable(): bool
    {
        if (count($this->children) <= 1) {
            return true;
        }

        $weights = [];
        foreach ($this->children as $child) {
            $weights[] = $child->getTotalWeight();
        }

        $first = array_pop($weights);
        foreach ($weights as $weight) {
            if ($weight !== $first) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return Program[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}

// build the tree
$rawLines = file(__DIR__ . '/in.txt');
$allPrograms = [];
while (count($allPrograms) !== count($rawLines)) {
    foreach ($rawLines as $line) {
        $split = explode(' -> ', trim($line));
        preg_match('/(\w+)\s\((\d+)\)/', $split[0], $out);
        [,$name, $weight] = $out;

        if (isset($allPrograms[$name])) {  // already initialised with all children
            continue;
        }

        $program = new Program($name, $weight);

        if (count($split) === 2) {  // leaf mode, no
            foreach (explode(", ", $split[1]) as $childName) {
                if (!isset($allPrograms[$childName])) {
                    continue 2;
                }
                $program->addChild($allPrograms[$childName]);
            }
        }
        $allPrograms[$program->getName()] = $program;
    }
}

/** @var Program $program */
foreach ($allPrograms as $program) {
    if (!$program->hasParent()) {
        echo "Root is: ", $program->getName(), "\n";
        break;
    }
}

// find one that is stable but the parent isn't.
foreach ($allPrograms as $program) {
    if (!$program->hasParent()) {
        continue;
    }

    if ($program->isStable() && !$program->getParent()->isStable()) {
        $unstableParent = $program->getParent();
        break;
    }
}

$weights = [];
foreach ($unstableParent->getChildren() as $child) {
    $weights[$child->getName()] = $child->getTotalWeight();
}

$counts = array_count_values($weights);

#print_r($counts);
$oddValue = array_flip($counts)[1];
unset($counts[$oddValue]);
$conformingValue = array_keys($counts)[0];

$oddChild = $allPrograms[array_flip($weights)[$oddValue]];

echo $oddChild->getWeight() + ($conformingValue - $oddValue), "\n";


echo "total time: ", (microtime(true) - $startTime), "\n";

