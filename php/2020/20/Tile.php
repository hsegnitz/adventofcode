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
        $this->right  = implode('', array_column($this->content, 9));
        $this->bottom = implode('', $this->content[9]);
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
            't' => $this->top,
            'l' => $this->left,
            'r' => $this->right,
            'b' => $this->bottom,
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


}
