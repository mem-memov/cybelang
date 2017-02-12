<?php

namespace MemMemov\GraphStore;

class Values
{
    private $store;

    public function __construct(
        ValueStore $store
    ) {
        $this->store = $store;
    }

    public function create(string $value)
    {
        $key = $this->store->getKey($value);

        return new ValueNode($this->store, $id);
    }
}