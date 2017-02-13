<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node;
use MemMemov\SpaceGraph\Value;

class GraphValue implements Value
{
    private $valueStore;
    private $key;
    private $node;

    public function __construct(
        ValueStore $valueStore,
        string $key,
        GraphNode $node
    ) {
        $this->valueStore = $valueStore;
        $this->key = $key;
        $this->node = $node;
    }

    public function getContents(): string
    {
        return $this->valueStore->value($this->key);
    }

    public function id(): int
    {
        return $this->node->id();
    }

    public function addNode(Node $node)
    {
        $this->node->addNode($node);
    }
}