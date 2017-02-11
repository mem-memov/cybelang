<?php

namespace MemMemov\GraphStore\ValueStore;

class Hash
{
    public function create(string $value): string
    {
        return md5($value);
    }
}