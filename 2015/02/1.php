<?php

class present
{
    /** @var int[] */
    private $dimensions;

    /**
     * present constructor.
     *
     * @param int[] $dimensions
     */
    public function __construct($dimensions)
    {
        $this->dimensions = $dimensions;
        sort($this->dimensions);
    }

    /**
     * @return int
     */
    private function surface()
    {
        $total = ($this->dimensions[0] * $this->dimensions[1])
            + ($this->dimensions[1] * $this->dimensions[2])
            + ($this->dimensions[2] * $this->dimensions[0]);

        return 2 * $total;
    }

    /**
     * @return int
     */
    private function extra()
    {
        return $this->dimensions[0] * $this->dimensions[1];
    }

    /**
     * @return int
     */
    public function wrappingPaper()
    {
        return $this->surface() + $this->extra();
    }

    /**
     * @return int
     */
    public function ribbon()
    {
        $temp = $this->dimensions[0] * $this->dimensions[1] * $this->dimensions[2];
        return $temp + (2 * ($this->dimensions[0] + $this->dimensions[1]));
    }
}

$paper  = [];
$ribbon = [];
foreach (file('in.txt') as $line) {
    $split = explode('x', trim($line));
    $present = new present($split);

    $paper[]  = $present->wrappingPaper();
    $ribbon[] = $present->ribbon();
}

echo 'paper: ', array_sum($paper);
echo "\nribbon: ", array_sum($ribbon);
