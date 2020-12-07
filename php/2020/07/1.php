<?php

$input = file('demo.txt');

class bag {
    private string $color;
    private array $children = [];
    private array $quantities = [];
    private array $parents = [];

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function addChild(bag $child, int $quantity): void
    {
        $this->children[$child->getColor()] = $child;
        $this->quantities[$child->getColor()] = $quantity;
        $child->addParent($this);
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    public function addParent(bag $parent): void
    {
        $this->parents[] = $parent;
    }
}

$listOfBagTypes = [];
$patternOwn = '/^(.*) bags/';
$patternContents = '/(\d+) (.*) bags?/';

$instructions = [];
foreach ($input as $rawRow) {
#    echo $rawRow;
    $split = explode (' contain ', $rawRow);
    $subSplit = explode (', ', $split[1]);
    preg_match($patternOwn, $split[0], $outOwn);
    if (trim($split[1]) === 'no other bags.') {
        $instructions[$outOwn[1]] = [];
        continue;
    }

    foreach ($subSplit as $subInst) {
#        echo $subInst;
        preg_match($patternContents, $subInst, $outSub);
        $instructions[$outOwn[1]][] = [
            'color' => $outSub[2],
            'quantity' => (int)$outSub[1],
        ];
    }
}

#print_r($instructions);

$bagTypes = [];
while (count($instructions) !== count($bagTypes)) {
    foreach ($instructions as $color => $children) {
        if (isset($bagTypes[$color])) {
            continue;
        }
        foreach ($children as $child) {
            if (!isset($bagTypes[$child['color']])) {
                continue 2;
            }
        }

        $newBag = new bag($color);
        foreach ($children as $child) {
            $newBag->addChild($bagTypes[$child['color']], $child['quantity']);
        }
        $bagTypes[$color] = $newBag;
    }
}
