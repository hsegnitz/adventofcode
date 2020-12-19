<?php

$startTime = microtime(true);

abstract class Scrambler
{
    abstract public function __construct(array $init);
    abstract public function process(string $input): string;
}

abstract class SwapScrambler extends Scrambler {}

class SwapPositionScrambler extends SwapScrambler {
    private int $posX;
    private int $posY;

    public function __construct(array $init)
    {
        $this->posX = (int)$init[0];
        $this->posY = (int)$init[3];
    }

    public function process(string $input): string
    {
        $temp = $input[$this->posX];
        $input[$this->posX] = $input[$this->posY];
        $input[$this->posY] = $temp;
        return $input;
    }
}

class SwapLetterScrambler extends SwapScrambler {
    private string $x;
    private string $y;

    public function __construct(array $init)
    {
        $this->x = $init[0];
        $this->y = $init[3];
    }

    public function process(string $input): string
    {
        $muhaha = [
            strpos($input, $this->x),
            '',
            '',
            strpos($input, $this->y),
        ];
        return (new SwapPositionScrambler($muhaha))->process($input);
    }
}

abstract class RotationScrambler extends Scrambler {
    protected function rotateRightBy(string $input, int $steps): string
    {
        $steps %= strlen($input);
        return substr($input, -$steps) . substr($input, 0, -$steps);
    }
}

class RotateRightScrambler extends RotationScrambler
{
    protected int $distance;

    public function __construct(array $init)
    {
        $this->distance = (int)$init[0];
    }

    public function process(string $input): string
    {
        return $this->rotateRightBy($input, $this->distance);
    }
}

class RotateLeftScrambler extends RotateRightScrambler
{
    public function process(string $input): string
    {
        return $this->rotateRightBy($input, strlen($input) - $this->distance);
    }
}

class RotatePositionScrambler extends RotationScrambler
{
    protected string $letter;

    public function __construct(array $init)
    {
        $this->letter = $init[4];
    }

    public function process(string $input): string
    {
        $index = strpos($input, $this->letter);
        if ($index >= 4) {
            ++$index;
        }
        ++$index;
        return $this->rotateRightBy($input, $index);
    }
}

class ReverseScrambler extends Scrambler {
    private int $posX;
    private int $posY;

    public function __construct(array $init)
    {
        $this->posX = (int)$init[1];
        $this->posY = (int)$init[3];
    }

    public function process(string $input): string
    {
        $temp = '';
        if ($this->posX > 0) {
            $temp .= substr($input, 0, $this->posX);
        }

        $temp .= strrev(substr($input, $this->posX, ($this->posY - $this->posX + 1)));

        if ($this->posY < strlen($input)-1) {
            $temp .= substr($input, $this->posY);
        }

        return $temp;
    }
}

class MoveScrambler extends Scrambler {
    private int $from;
    private int $to;

    public function __construct(array $init)
    {
        $this->from = (int)$init[1];
        $this->to   = (int)$init[4];
    }

    public function process(string $input): string
    {
        $removedChar = $input[$this->from];
        $input = str_replace($removedChar, '', $input);
        if ($this->to === 0) {
            return $removedChar . $input;
        }
        if ($this->to === strlen($input)) {   // no "-1" as it's already short
            return $input . $removedChar;
        }

        return substr($input, 0, $this->to)
            . $removedChar
            . substr($input, $this->to);
    }
}





class ScramblerFactory
{
    public static function getScrambler(string $input): ?Scrambler
    {
        $split = explode(' ', trim($input));
        $family = array_shift($split);
        if ('swap' === $family) {
            $type = array_shift($split);
            if ('position' === $type) {
                return new SwapPositionScrambler($split);
            }
            if ('letter' === $type) {
                return new SwapLetterScrambler($split);
            }
        }
        if ('rotate' === $family) {
            $type = array_shift($split);
            if ('left' === $type) {
                return new RotateLeftScrambler($split);
            }
            if ('right' === $type) {
                return new RotateRightScrambler($split);
            }
            if ('based' === $type) {
                return new RotatePositionScrambler($split);
            }
        }
        if ('reverse' === $family) {
            return new ReverseScrambler($split);
        }
        if ('move' === $family) {
            return new MoveScrambler($split);
        }
        return null;
    }
}

$password = 'abcde';

foreach (file(__DIR__ . '/demo.txt') as $row) {
    $scrambler = ScramblerFactory::getScrambler($row);
    echo $password = $scrambler->process($password), "\n";
}




echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
