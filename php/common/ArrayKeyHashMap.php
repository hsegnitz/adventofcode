<?php

namespace common;

use Override;

/** not done yet */


class ArrayKeyHashMap implements \ArrayAccess, \Countable
{
    private array $internalState = [];
    public function __construct(private readonly int $dimensions = 1, private readonly array $separators = [""])
    {}

    private function transformKey(array $key): string
    {
        if ($this->dimensions === 1) {
            return implode($this->separators[0], $key);
        }
        if ($this->dimensions === 2) {
            $temp = [];
            foreach ($key as $row) {
                $temp = implode($this->separators[0], $row);
            }
            return implode($this->separators[1], $temp);
        }
    }

    #[Override] public function offsetExists(mixed $offset): bool
    {
        return isset($this->internalState[$this->transformKey($offset)]);
    }

    #[Override] public function offsetGet(mixed $offset): mixed
    {
        return $this->internalState[$this->transformKey($offset)];
    }

    #[Override] public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->internalState[$this->transformKey($offset)] = $value;
    }

    #[Override] public function offsetUnset(mixed $offset): void
    {
        unset($this->internalState[$this->transformKey($offset)]);
    }

    public function count(): int
    {
        return count($this->internalState);
    }
}

