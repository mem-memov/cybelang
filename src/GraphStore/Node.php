<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node as SpaceGraphNode;

class Node implements SpaceGraphNode
{
    private $store;
    private $id;

    public function __construct(
        NodeStore $store,
        int $id
    ) {
        $this->store = $store;
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function addNode(SpaceGraphNode $node)
    {
        $this->store->connect($this->id, $node->id());
    }
}