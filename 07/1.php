<?php

class node {
    /** @var node[] */
    private $parents = [];

    /** @var node[] */
    private $children = [];

    /** @var string */
    private $name;

    /** @var bool */
    private $completed = false;

    /**
     * node constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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

    public function haveAllParentsCompleted()
    {
        $completed = true;
        foreach ($this->parents as $parent) {
            $completed = $completed && $parent->isCompleted();
        }

        return $completed;
    }

    public function isCompleted()
    {
        return $this->completed && $this->haveAllParentsCompleted();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCompleted($completed = true)
    {
        $this->completed = $completed;
    }
}


/**
 * @param node[] $all
 * @return boolean
 */
function finished($all)
{
    foreach ($all as $item) {
        if (!$item->haveAllParentsCompleted()) {
            return false;
        }
    }
    return true;
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

//print_r($linear);

$solution = '';
while (strlen($solution) < count($linear)) {
    foreach ($linear as $elem) {
        if ($solution !== '' && false !== strpos($elem->getName(), $solution)) {
            continue;
        }

        if ($elem->haveAllParentsCompleted()) {
            echo ".";
            $elem->setCompleted();
            foreach ($elem->getChildren() as $child) {
                echo "x";
                if ($child->haveAllParentsCompleted() && ($solution === '' || false === strpos($elem->getName(), $solution))) {
                    $solution .= $elem->getName();
                    continue 2;
                }
            }
            $elem->setCompleted(false);
        }
    }
}

echo $solution;



