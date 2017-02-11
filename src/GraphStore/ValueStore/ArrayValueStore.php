<?php

namespace MemMemov\GraphStore\ValueStore;

use MemMemov\GraphStore\ValueStore;

class ArrayValueStore implements ValueStore
{
    private $hash;
    private $keyValue;
    private $valueKey;

    public function __construct(Hash $hash)
    {
        $this->hash = $hash;
        $this->keyValue = [];
        $this->valueKey = [];
    }

    public function bind(string $key, string $value)
    {
        $this->keyValue[$key] = $value;

        $hash = $this->hash->create($value);
        $this->valueKey[$hash] = $key;
    }

    public function getValue(string $key): string
    {
        return $this->keyValue[$key];
    }

    public function getKey(string $value): string
    {
        $hash = $this->hash->create($value);

        return $this->valueKey[$hash];
    }
}