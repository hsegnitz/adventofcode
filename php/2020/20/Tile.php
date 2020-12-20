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
    private bool $flippedHorz = false;
    private bool $flippedVert = false;

    private ?Tile $topNeighbour;
    private ?Tile $leftNeighbour;
    private ?Tile $rightNeighbour;
    private ?Tile $bottomNeighbour;

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
     * @return Tile|null
     */
    public function getTopNeighbour(): ?Tile
    {
        return $this->topNeighbour;
    }

    /**
     * @return Tile|null
     */
    public function getLeftNeighbour(): ?Tile
    {
        return $this->leftNeighbour;
    }

    /**
     * @return Tile|null
     */
    public function getRightNeighbour(): ?Tile
    {
        return $this->rightNeighbour;
    }

    /**
     * @return Tile|null
     */
    public function getBottomNeighbour(): ?Tile
    {
        return $this->bottomNeighbour;
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
        if ($this->flippedHorz) {
            return strrev($this->top);
        }
        return $this->top;
    }

    public function getLeft(): string
    {
        if ($this->flippedHorz) {
            return $this->right;
        }
        return $this->left;
    }

    public function getRight(): string
    {
        if ($this->flippedHorz) {
            return $this->left;
        }
        return $this->right;
    }

    public function getBottom(): string
    {
        if ($this->flippedHorz) {
            return strrev($this->bottom);
        }
        return $this->bottom;
    }

    public function setOrientation(string $orientation): void
    {
        $this->orientation = $orientation;
    }

    public function setFlippedHorz(bool $flippedHorz): void
    {
        $this->flippedHorz = $flippedHorz;
    }

    public function setFlippedVert(bool $flippedVert): void
    {
        $this->flippedVert = $flippedVert;
    }

    public function hasMatchingEdge(Tile $tile): bool
    {
        $ownEdges = [
            $this->top,
            $this->left,
            $this->right,
            $this->bottom,
        ];
        $foreignEdges = [
            $tile->getTop() => true,
            $tile->getLeft() => true,
            $tile->getRight() => true,
            $tile->getBottom() => true,
            strrev($tile->getTop()) => true,
            strrev($tile->getLeft()) => true,
            strrev($tile->getRight()) => true,
            strrev($tile->getBottom()) => true,
        ];

        foreach ($ownEdges as $edge) {
            if (isset($foreignEdges[$edge])) {
                return true;
            }
        }
        return false;
    }

}
