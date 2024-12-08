<?php

namespace common;
class ArrayKeyCache implements \Countable{

    public function __construct(private readonly string $separator = ':')
    {}

    private array $cache = [];

    private function makeKey(array $key): string
    {
        return implode($this->separator, $key);
    }

    public function store(array $key, $value): void
    {
        $this->cache[$this->makeKey($key)] = $value;
    }

    public function retrieve(array $key): mixed
    {
        return $this->cache[$this->makeKey($key)] ?? null;
    }

    public function has(array $key): bool
    {
        return isset($this->cache[$this->makeKey($key)]);
    }

    public function count(): int
    {
        return count($this->cache);
    }
}
