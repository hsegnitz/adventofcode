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


echo "total time: ", (microtime(true) - $startTime), "\n";

