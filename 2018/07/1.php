<?php

class node {
    /** @var node[] */
    private $parents = [];

    /** @var node[] */
    private $children = [];

    /** @var string */
    private $name;

    /**
     * node constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addParent(node $parent)
    {
        $this->parents[$parent->getName()] = $parent;
        $parent->addChild($this);
    }

    public function hasParents()
    {
        return (count($this->parents) > 0);
    }

    public function addChild(node $child)
    {
        $this->children[$child->getName()] = $child;
    }

    public function hasChildren()
    {
        return (count($this->children) > 0);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function evaluateParents($solution)
    {
        $allParentsInSolution = true;
        ksort($this->parents);
        foreach ($this->parents as $parent) {
            if (false === strpos($solution, $parent->getName())) {
                return false;
            }
            $allParentsInSolution = $allParentsInSolution && $parent->evaluateParents($solution);
        }

        return $allParentsInSolution;
    }

    public function walk($solution)
    {
        echo $solution, " ", $this->name, " p ", implode('', array_keys($this->parents)), " c ", implode('', array_keys($this->children)), "\n";
        // check for unfinished parents in solution string
        if ($solution !== '' && false === $this->evaluateParents($solution)) {
            return $solution; // this one has unfinished parents -> not a candidate
        }

        $solution .= $this->name;
        ksort($this->children);

        //reset this loop over and over again for each succesfully evaluated child
        while (false !== ($child = each($this->children))) {
            if (false === strpos($solution, $child[1]->getName())) {
                $oldLen = strlen($solution);
                $solution = $child[1]->walk($solution);
                if ($oldLen !== strlen($solution)) {
                    unset($this->children[$child[1]->getName()]);
                    reset($this->children);
                }
            }
        }

        return $solution;
    }
}

$input = file('in.txt');
#$input = file('small.txt');

$regex = '/Step (\w) must be finished before step (\w) can begin/';

// build grid
/** @var node[] $linear */
$linear = [];
foreach (range('A', 'Z') as $key) {
    $linear[$key] = new node($key);
}

/*
IBJTUWGFKDNVEYAOMPCHMCQRLSZX
IBJTUWGFKDNVEYAHOMPCQRLSZX
*/
foreach ($input as $line) {
    $out = [];
    preg_match($regex, $line, $out);

    $linear[$out[2]]->addParent($linear[$out[1]]);
}

$rootNode = new node('-');

foreach ($linear as $step) {
    if (!$step->hasParents()) {
        $step->addParent($rootNode);
    }
}

echo "\n\n\n", $rootNode->walk('');
