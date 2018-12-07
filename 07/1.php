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
        $this->parents[] = $parent;
        $parent->addChild($this);
    }

    public function hasParents()
    {
        return (count($this->parents) > 0);
    }

    public function addChild(node $child)
    {
        $this->children[] = $child;
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
        foreach ($this->parents as $parent) {
            if (false === strpos($parent->getName(), $solution)) {
                return false;
            }
            $allParentsInSolution = $allParentsInSolution && $parent->evaluateParents($solution);
        }
        return $allParentsInSolution;
    }

    public function evaluate($solution)
    {
        echo $solution, "\n";
        // check for unfinished parents in solution string
        if ($solution !== '' && false === $this->evaluateParents($solution)) {
            return false; // this one has unfinished parents -> not a candidate
        }

        if (strlen($solution) === 6) {
            die($solution);
        }

        foreach ($this->children as $child) {
            if ($child->evaluate($solution . $this->name)) {
                $solution .= $this->name;
            }
        }
    }
}

#$input = file('in.txt');
$input = file('small.txt');

$regex = '/Step (\w) must be finished before step (\w) can begin/';

// build grid
/** @var node[] $linear */
$linear = [];
foreach (range('A', 'F') as $key) {
    $linear[$key] = new node($key);
}



foreach ($input as $line) {
    $out = [];
    preg_match($regex, $line, $out);

    $linear[$out[2]]->addParent($linear[$out[1]]);
}

foreach ($linear as $step) {
    $step->evaluate('');
}
