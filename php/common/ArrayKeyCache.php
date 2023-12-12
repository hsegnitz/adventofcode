<?php

namespace common;
class ArrayKeyCache {

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
}
