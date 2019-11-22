<?php

class Instruction {

    /** @var string */
    private $command;

    /** @var int */
    private $startX;

    /** @var int */
    private $startY;

    /** @var int */
    private $endY;

    /** @var int */
    private $endX;

    /**
     * Instruction constructor.
     *
     * @param string $raw
     */
    public function __construct($raw)
    {
        $split = explode(' ', str_replace(['turn ', ','], ['turn', ' '], $raw));
        $this->command = $split[0];
        $this->startX  = (int)$split[1];
        $this->startY  = (int)$split[2];
        $this->endX    = (int)$split[4];
        $this->endY    = (int)$split[5];
    }

    /**
     * @return bool
     */
    public function isToggle()
    {
        return $this->command === 'toggle';
    }

    /**
     * @return bool
     */
    public function isTurnOn()
    {
        return $this->command === 'turnon';
    }

    /**
     * @return bool
     */
    public function isTurnOff()
    {
        return $this->command === 'turnoff';
    }

    /**
     * @return int
     */
    public function getStartX(): int
    {
        return $this->startX;
    }

    /**
     * @return int
     */
    public function getStartY(): int
    {
        return $this->startY;
    }

    /**
     * @return int
     */
    public function getEndY(): int
    {
        return $this->endY;
    }

    /**
     * @return int
     */
    public function getEndX(): int
    {
        return $this->endX;
    }

    public function __toString()
    {
        return $this->command . ' ' . $this->startX . ' ' . $this->startY . ' ' . $this->endX . ' ' . $this->endY;
    }
}

$raw = file('./in.txt', FILE_IGNORE_NEW_LINES);

$instructions = [];
foreach ($raw as $line) {
    $ins = new Instruction($line);
    $instructions[] = $ins;
    echo $ins, "\n";
}

$row  = array_fill(0, 1000, false);
$grid = array_fill(0, 1000, $row);

/** @var Instruction $instr */
foreach ($instructions as $instr) {
    for ($i = $instr->getStartX(); $i <= $instr->getEndX(); $i++) {
        for ($j = $instr->getStartY(); $j <= $instr->getEndY(); $j++) {
            if ($instr->isToggle()) {
                $grid[$i][$j] = !$grid[$i][$j];
            } else if ($instr->isTurnOn()) {
                $grid[$i][$j] = true;
            } else if ($instr->isTurnOff()) {
                $grid[$i][$j] = false;
            } else {
                throw new RuntimeException('You should not be able to reach this code, ever!');
            }
        }
    }
}

$count = 0;
foreach ($grid as $row) {
    foreach ($row as $elem) {
        if ($elem) {
            ++$count;
        }
    }
}

echo $count;
