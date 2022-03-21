<?php

class SpaceObject {
    private ?SpaceObject $parent = null;
    private array $children = [];

    public function __construct(private string $name) {}

    public function addChild(SpaceObject $child): void
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    public function setParent(SpaceObject $parent): void
    {
        $this->parent = $parent;
    }

    public function countParents(): int
    {
        if (null !== $this->parent) {
            return 1 + $this->parent->countParents();
        }
        return 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): SpaceObject
    {
        return $this->parent;
    }

    public function countTowardsCommonAncestor(string $searchFor): bool
    {
        if (count($this->children) === 0) {
            return false;
        }

        foreach ($this->children as $child) {
            if ($child->getName() === $searchFor || $child->countTowardsCommonAncestor($searchFor)) {
                return true;
            }
        }

        return false;
    }
}

