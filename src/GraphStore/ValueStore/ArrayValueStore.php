<?php

namespace MemMemov\GraphStore\ValueStore;

use MemMemov\GraphStore\ValueStore;

class ArrayValueStore implements ValueStore
{
    private $hash;
    private $keyPath;
    private $valuePath;
    private $keyValue;
    private $valueKey;

    public function __construct(Hash $hash, string $keyPath, string $valuePath)
    {
        $this->hash = $hash;
        $this->keyPath = $keyPath;
        $this->valuePath = $valuePath;

        $this->keyValue = [];
        if (file_exists($this->keyPath)) {
            $keyContents = file_get_contents($this->keyPath);
            if (!empty($keyContents)) {
                $this->keyValue = unserialize($keyContents);
            }
        }

        $this->valueKey = [];
        if (file_exists($this->valuePath)) {
            $valueContents = file_get_contents($this->valuePath);
            if (!empty($valueContents)) {
                $this->valueKey = unserialize($valueContents);
            };
        };
    }

    public function __destruct()
    {
        file_put_contents($this->keyPath, serialize($this->keyValue));
        file_put_contents($this->valuePath, serialize($this->valueKey));
    }

    public function bind(string $key, string $value)
    {
        $this->keyValue[$key] = $value;

        $hash = $this->hash->create($value);
        $this->valueKey[$hash] = $key;
    }

    public function value(string $key): string
    {
        return $this->keyValue[$key];
    }

    public function key(string $value): string
    {
        $hash = $this->hash->create($value);

        return $this->valueKey[$hash];
    }

    public function hasValue(string $value): bool
    {
        $hash = $this->hash->create($value);

        return array_key_exists($hash, $this->valueKey);
    }

    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->keyValue);
    }
}