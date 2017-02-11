<?php

namespace MemMemov\GraphStore;

interface ValueStore
{
    public function bind(string $key, string $value);

    public function getValue(string $key): string;

    public function getKey(string $value): string;
}