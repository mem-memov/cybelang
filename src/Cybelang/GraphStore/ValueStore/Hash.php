<?php

namespace MemMemov\Cybelang\GraphStore\ValueStore;

class Hash
{
    public function create(string $value): string
    {
        return md5($value);
    }
}