<?php

$startTime = microtime(true);

$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example0.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example1.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example2.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example3.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example4.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

class SnailfishNumber {

    public function __construct(private $x, private $y, private ?SnailfishNumber $parent = null)
    {
        if ($x instanceof self) {
            $x->setParent($this);
        }
        if ($y instanceof self) {
            $y->setParent($this);
        }
    }

    public function setParent(SnailfishNumber $parent): void
    {
        $this->parent = $parent;
    }

    public function __toString(): string
    {
        return '[' . $this->x . ',' . $this->y . ']';
    }

    public static function fromString(string $line, ?SnailfishNumber $parent = null): SnailfishNumber
    {
        // find the comma at bracket count 0
        $bracketCount = 0;
        for ($i = 1, $iMax = strlen($line)-1; $i < $iMax; $i++) {
            if ($line[$i] === "[") {
                ++$bracketCount;
                continue;
            }
            if ($line[$i] === "]") {
                --$bracketCount;
                continue;
            }
            if ($line[$i] === "," && $bracketCount === 0) {
                $left  = substr($line, 1, $i-1);
                $right = substr($line, $i+1, -1);
                if (!is_numeric($left)) {
                    $left = self::fromString($left);
                }
                if (!is_numeric($right)) {
                    $right = self::fromString($right);
                }
                return new self($left, $right);
            }
        }
        throw new RuntimeException('This should not happen.');
    }

    public function add($summand): void
    {
        $this->x = new self($this->x, $this->y, $this);
        $this->y = $summand;
        if ($this->y instanceof self) {
            $this->y->setParent($this);
        }
        $this->reduce();
    }

    public function reduce(): void
    {
        while (true) {
            if ($this->explode()) {
                // there was an explosion -> another round
                continue;
            }
            if ($this->split()) {
                // there was a split -> another round
                continue;
            }
            break;
        }
    }

    /**
     * @param int $depth
     * @return bool returns true if there was an explosion necessary
     */
    private function explode(int $depth = 0): bool
    {
        if ($this->x instanceof self && $this->x->explode($depth+1)) {
            return true;
        }
        if ($this->y instanceof self && $this->y->explode($depth+1)) {
            return true;
        }
        if ($depth === 4) {
            $this->parent->addLeft($this->x);
            $this->parent->addRight($this->y);
            $this->parent->destroyMe($this);
            return true;
        }
        return false;
    }

    public function destroyMe(SnailfishNumber $me) {
        if ($this->x === $me) {
            $this->x = 0;
        }
        if ($this->y === $me) {
            $this->y = 0;
        }
    }

    public function addLeft(int $amount): void
    {
        if ($this->x instanceof self) {
            if ($this->parent instanceof self) {
                $this->parent->addLeft($amount);
            }
            return;
        }
        $this->x += $amount;
    }

    public function addRight(int $amount): void
    {
        if ($this->y instanceof self) {
            if ($this->parent instanceof self) {
                $this->parent->addRight($amount);
            }
            return;
        }
        $this->y += $amount;
    }

    /**
     * @return bool returns true if there was a split necessary
     */
    private function split(): bool
    {
        return false;
    }
}


$originalNumbers = [];
foreach ($input as $line) {
    $originalNumbers[] = SnailfishNumber::fromString($line);
}

$first = array_shift($originalNumbers);
foreach ($originalNumbers as $on) {
    $first->add($on);
}

echo $first;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

