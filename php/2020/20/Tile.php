<?php

class Tile {
    public const ORIENTATION_TOP = 'top';
    public const ORIENTATION_LEFT = 'left';
    public const ORIENTATION_RIGHT = 'right';
    public const ORIENTATION_BOTTOM = 'bottom';

    public const ORIENTATIONS = [
        self::ORIENTATION_TOP,
        self::ORIENTATION_LEFT,
        self::ORIENTATION_BOTTOM,
        self::ORIENTATION_RIGHT,
    ];

    private int $id;
    private array $content = [];   // Y then X

    private string $top;
    private string $left;
    private string $right;
    private string $bottom;

    private string $orientation = self::ORIENTATION_TOP;
    private bool $flipped = false;

    public function __construct(string $rawTile)
    {
        $rows = explode("\n", $rawTile);
        $first = array_shift($rows);
        preg_match('/^Tile (\d+):/', $first, $out);
        $this->id = (int)$out[1];

        foreach ($rows as $k => $row) {
            $this->content[] = str_split($row);
        }

        $this->top    = implode('', $this->content[0]);
        $this->left   = implode('', array_column($this->content, 0));
        $this->right  = implode('', array_column($this->content, count($this->content)-1));
        $this->bottom = implode('', $this->content[count($this->content)-1]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getTop(): string
    {
        return $this->top;
    }

    public function getLeft(): string
    {
        return $this->left;
    }

    public function getRight(): string
    {
        return $this->right;
    }

    public function getBottom(): string
    {
        return $this->bottom;
    }

    public function setOrientation(string $orientation): void
    {
        $this->orientation = $orientation;
    }

    public function setFlipped(bool $flipped): void
    {
        $this->flipped = $flipped;
    }

    public function getOrientation(): string
    {
        return $this->orientation;
    }

    public function isFlipped(): bool
    {
        return $this->flipped;
    }



    /*
     * returns the own matching edge's position with the foreign edge and flippiness.
     * tB  =>  top edge matches the inverse of the foreign bottom edge
     */
    public function findMatchingEdgesAndOrientation(Tile $tile): ?string
    {
        $ownEdges = [
            't' => $this->getAppliedTop(),
            'l' => $this->getAppliedLeft(),
            'r' => $this->getAppliedRight(),
            'b' => $this->getAppliedBottom(),
        ];
        $foreignEdges = [
            $tile->getTop() => 't',
            $tile->getLeft() => 'l',
            $tile->getRight() => 'r',
            $tile->getBottom() => 'b',
            strrev($tile->getTop()) => 'T',
            strrev($tile->getLeft()) => 'L',
            strrev($tile->getRight()) => 'R',
            strrev($tile->getBottom()) => 'B',
        ];

        foreach ($ownEdges as $k => $edge) {
            if (isset($foreignEdges[$edge])) {
                return $k . $foreignEdges[$edge];
            }
        }
        return null;
    }

    public function hasMatchingEdge(Tile $tile): bool
    {
        return null !== $this->findMatchingEdgesAndOrientation($tile);
    }

    public function getAppliedTop(): string
    {
        switch ($this->getOrientation()) {
            case self::ORIENTATION_TOP:
                if ($this->isFlipped()) {
                    return strrev($this->getTop());
                }
                return $this->getTop();
            case self::ORIENTATION_LEFT:
                if ($this->isFlipped()) {
                    return $this->getLeft();
                }
                return $this->getRight();
            case self::ORIENTATION_BOTTOM:
                if ($this->isFlipped()) {
                    return $this->getBottom();
                }
                return strrev($this->getBottom());
            case self::ORIENTATION_RIGHT:
                if ($this->isFlipped()) {
                    return strrev($this->getRight());
                }
                return strrev($this->getLeft());
        }
        throw new RuntimeException('Are we in the right dimension?!');
    }

    public function getAppliedBottom(): string
    {
        switch ($this->getOrientation()) {
            case self::ORIENTATION_TOP:
                if ($this->isFlipped()) {
                    return strrev($this->getBottom());
                }
                return $this->getBottom();
            case self::ORIENTATION_LEFT:
                if ($this->isFlipped()) {
                    return $this->getRight();
                }
                return $this->getLeft();
            case self::ORIENTATION_BOTTOM:
                if ($this->isFlipped()) {
                    return $this->getTop();
                }
                return strrev($this->getTop());
            case self::ORIENTATION_RIGHT:
                if ($this->isFlipped()) {
                    return strrev($this->getLeft());
                }
                return strrev($this->getRight());
        }
        throw new RuntimeException('Are we in the right dimension?!');
    }

    public function getAppliedLeft(): string
    {
        switch ($this->getOrientation()) {
            case self::ORIENTATION_TOP:
                if ($this->isFlipped()) {
                    return $this->getRight();
                }
                return $this->getLeft();
            case self::ORIENTATION_LEFT:
                if ($this->isFlipped()) {
                    return $this->getTop();
                }
                return strrev($this->getTop());
            case self::ORIENTATION_BOTTOM:
                if ($this->isFlipped()) {
                    return strrev($this->getLeft());
                }
                return strrev($this->getRight());
            case self::ORIENTATION_RIGHT:
                if ($this->isFlipped()) {
                    return strrev($this->getBottom());
                }
                return $this->getBottom();
        }
        throw new RuntimeException('Are we in the right dimension?!');
    }

    public function getAppliedRight(): string
    {
        switch ($this->getOrientation()) {
            case self::ORIENTATION_TOP:
                if ($this->isFlipped()) {
                    return $this->getLeft();
                }
                return $this->getRight();
            case self::ORIENTATION_LEFT:
                if ($this->isFlipped()) {
                    return $this->getBottom();
                }
                return strrev($this->getBottom());
            case self::ORIENTATION_BOTTOM:
                if ($this->isFlipped()) {
                    return strrev($this->getRight());
                }
                return strrev($this->getLeft());
            case self::ORIENTATION_RIGHT:
                if ($this->isFlipped()) {
                    return strrev($this->getTop());
                }
                return $this->getTop();
        }
        throw new RuntimeException('Are we in the right dimension?!');
    }

    public function getCroppedAndAlignedContent(): array
    {
        $cropped = [];
        for ($y = 1; $y < count($this->content)-1; $y++) {
            $cropped[] = array_slice($this->content[$y], 1, count($this->content[$y]) - 2);
        }

        if ($this->getOrientation() === self::ORIENTATION_TOP) {
            if ($this->isFlipped()) {
                return $this->flipCols($cropped);
            }
            return $cropped;
        }

        if ($this->getOrientation() === self::ORIENTATION_BOTTOM)
        {
            if ($this->isFlipped()) {
                return array_reverse($cropped);
            }
            return array_reverse($this->flipCols($cropped));
        }

        if ($this->isFlipped()) {
            $cropped = $this->flipCols($cropped);
        }

        if ($this->getOrientation() === self::ORIENTATION_LEFT)
        {
            return $this->rotateLeft($cropped);
        }

        return $this->rotateRight($cropped);
    }

    private function flipCols($grid): array
    {
        $newCropped = [];
        foreach ($grid as $row) {
            $newCropped[] = array_reverse($row);
        }
        return $newCropped;
    }

    private function rotateLeft($grid): array
    {
        $new = [];
        $len = count($grid);

        for ($y = 0; $y < $len; $y++) {
            for ($x = 0; $x < $len; $x++) {
                $new[$y][$x] = $grid[$x][$len-1-$y];
            }
        }
        return $new;
    }

    private function rotateRight($grid): array
    {
        $new = [];
        $len = count($grid);

        for ($y = 0; $y < $len; $y++) {
            for ($x = 0; $x < $len; $x++) {
                $new[$y][$x] = $grid[$len-1-$x][$y];
            }
        }
        return $new;
    }
}
