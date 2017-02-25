<?php

namespace MemMemov\Cybelang\GraphStore;

interface ValueStore
{
    public function bind(string $key, string $value);

    public function value(string $key): string;

    public function key(string $value): string;

    public function hasValue(string $value): bool;

    public function hasKey(string $key): bool;
}