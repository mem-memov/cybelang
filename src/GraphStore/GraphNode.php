<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node;

class GraphNode implements Node
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

    public function addNode(Node $node)
    {
        $this->store->connect($this->id, $node->id());
    }

    public function has(Node $node): bool
    {
        $this->store->contains($this->id, $node->id());
    }

    public function nodes(): array
    {
        $ids = $this->store->read($this->id);

        return array_map(function(int $id) {
            return new self($this->store, $id);
        }, $ids);
    }
}