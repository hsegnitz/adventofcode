<?php

class cart
{
    /** @var int */
    private static $instanceCount = 0;

    /** @var string */
    private $direction;

    /** @var string */
    private $lastTurn = 'right';

    /** @var int */
    private $id;

    /**
     * cart constructor.
     *
     * @param string $direction
     */
    public function __construct($direction)
    {
        $this->direction = $direction;
        $this->id = ++self::$instanceCount;
    }

    public function turn($tile)
    {
        if ('+' === $tile) {
            return $this->direction = $this->intersect();
        }

        if ('/' === $tile || '\\' === $tile) {
            return $this->direction = $this->curve($tile);
        }

        if ('-' === $tile || '|' === $tile) {
            return $this->direction;
        }

        throw new RuntimeException('Maaaaaan!');
    }

    public function __toString()
    {
        return $this->direction;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * sets new direction -- has to be called upon entering an intersection
     */
    private function intersect()
    {
        switch ($this->lastTurn) {
            case 'right':
                return $this->left();
            case 'left':
                $this->lastTurn = 'straight';
                return $this->direction;
            case 'straight':
                return $this->right();
        }
        throw new RuntimeException('Seriously??!');
    }

    private function left()
    {
        $this->lastTurn = 'left';
        switch ($this->direction) {
            case 'v':
                return '>';
            case '>':
                return '^';
            case '^':
                return '<';
            case '<':
                return 'v';
        }
        throw new RuntimeException('WTH?!');
    }

    private function right()
    {
        $this->lastTurn = 'right';
        switch ($this->direction) {
            case 'v':
                return '<';
            case '>':
                return 'v';
            case '^':
                return '>';
            case '<':
                return '^';
        }
        throw new RuntimeException('WTF?!');
    }

    /**
     * @param  string $curve
     * @return string
     */
    public function curve($curve)
    {
        if ('/' === $curve) {
            switch ($this->direction) {
                case 'v':
                    return '<';
                case '>':
                    return '^';
                case '^':
                    return '>';
                case '<':
                    return 'v';
            }
            throw new RuntimeException('This is fine!');
        }

        if ('\\' === $curve) {
            switch ($this->direction) {
                case 'v':
                    return '>';
                case '>':
                    return 'v';
                case '^':
                    return '<';
                case '<':
                    return '^';
            }
            throw new RuntimeException('You are doing it wrong!!');
        }

        throw new RuntimeException('Famous last words...');
    }
}


function printMap($trackMap, $cartMap)
{
    $trackLines = count($trackMap);
    for ($i = 0; $i < $trackLines; $i++) {
        $trackCols = count($trackMap[$i]);
        for ($j = 0; $j < $trackCols; $j++) {
            if (isset($cartMap[$i][$j])) {
                $lastX = $j;
                $lastY = $i;
                echo $cartMap[$i][$j];
            } else {
                echo $trackMap[$i][$j];
            }
        }
        echo "\n";
    }
    echo "\n$lastX,$lastY\n";
}

function tick($trackMap, &$cartMap)
{
    $seen = [];
    $trackLines = count($trackMap);
    for ($i = 0; $i < $trackLines; $i++) {
        $trackCols = count($trackMap[$i]);
        for ($j = 0; $j < $trackCols; $j++) {
            if (isset($cartMap[$i][$j])) {
                /** @var cart $cart */
                $cart = $cartMap[$i][$j];
                if (isset($seen[$cart->getId()])) {
                    continue;
                }
                $seen[$cart->getId()] = true;
                // move then turn
                $newX = $i;
                $newY = $j;
                switch ((string)$cart) {
                    case 'v':
                        ++$newX;
                        break;
                    case '>':
                        ++$newY;
                        break;
                    case '^':
                        --$newX;
                        break;
                    case '<':
                        --$newY;
                        break;
                }

                $cartMap[$i][$j] = null;
                if (isset($cartMap[$newX][$newY])) {
                    unset($seen[$cartMap[$newX][$newY]->getId()], $seen[$cart->getId()]);
                    $cartMap[$newX][$newY] = null;
                } else {
                    $cartMap[$newX][$newY] = $cart;
                    $cart->turn($trackMap[$newX][$newY]);
                }
            }
        }
    }

    if (count($seen) === 1) {
        printMap($trackMap, $cartMap);
        die();
    }
}



// read map -- symbols into 2d array

$trackMap = [];

foreach (file('in.txt') as $line) {
    $line = rtrim($line, "\n");
    $trackMap[] = str_split($line, 1);
}

// when encountering a cart, place it in cart-map and then repair the tile with a straight track piece
$cartMap  = [];
$trackLines = count($trackMap);
for ($i = 0; $i < $trackLines; $i++) {
    $cartMap[$i] = [];
    $trackCols = count($trackMap[$i]);
    for ($j = 0; $j < $trackCols; $j++) {
        switch ($trackMap[$i][$j]) {
            case 'v':
            case '^':
                $cartMap[$i][$j] = new cart($trackMap[$i][$j]);
                $trackMap[$i][$j] = '|';
                break;
            case '<':
            case '>':
                $cartMap[$i][$j] = new cart($trackMap[$i][$j]);
                $trackMap[$i][$j] = '-';
                break;
            default:
                $cartMap[$i][$j] = null;
        }
    }
}

while (true) {
    tick($trackMap, $cartMap);
}
