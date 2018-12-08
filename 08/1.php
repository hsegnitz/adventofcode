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

    public function metadataSum()
    {
        $sum = array_sum($this->metadata);
        foreach ($this->children as $child) {
            $sum += $child->metadataSum();
        }
        return $sum;
    }
}

$root = new node($flat);

/*print_r($root);
print_r($flat);*/

echo $root->metadataSum();