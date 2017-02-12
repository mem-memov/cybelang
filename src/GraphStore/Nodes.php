<?php

namespace MemMemov\GraphStore;

class Nodes
{
    private $store;

    public function __construct(
        NodeStore $store
    ) {
        $this->store = $store;
    }

    public function create()
    {
        $id = $this->store->create();

        return new Node($this->store, $id);
    }
}