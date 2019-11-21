<?php

$flat = explode(' ', trim(file_get_contents('in.txt')));

//print_r($flat);

class node
{
    /** @var node[] */
    private $children = [];

    /** @var int[] */
    private $metadata = [];

    public function __construct(&$numbers)
    {
        $numChildren = array_shift($numbers);
        $numMeta     = array_shift($numbers);

        while (count($this->children) < $numChildren) {
            $this->children[] = new node($numbers);
        }

        for ($m = 0; $m < $numMeta; $m++) {
            $this->metadata[] = array_shift($numbers);
        }
    }

    public function value()
    {
        if (count($this->children) === 0) {
            return array_sum($this->metadata);
        }

        $sum = 0;
        foreach ($this->metadata as $index) {
            if (isset($this->children[$index-1])) {
                $sum += $this->children[$index-1]->value();
            }
        }

        return $sum;
    }
}

$root = new node($flat);

/*print_r($root);
print_r($flat);*/

echo $root->value();