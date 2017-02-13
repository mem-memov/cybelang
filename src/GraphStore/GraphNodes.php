<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node;

class GraphNodes
{
    private $store;

    public function __construct(
        NodeStore $store
    ) {
        $this->store = $store;
    }

    public function create(): GraphNode
    {
        $id = $this->store->create();

        return new GraphNode($this->store, $id);
    }

    public function read(int $id): GraphNode
    {
        return new GraphNode($this->store, $id);
    }
}