<?php

namespace MemMemov\GraphStore;

interface ValueStore
{
    public function bind(string $key, string $value);

    public function value(string $key): string;

    public function key(string $value): string;
}