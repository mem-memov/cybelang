<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node;
use MemMemov\SpaceGraph\Value;
use MemMemov\SpaceGraph\Graph;

class GraphStore implements Graph
{
    private $nodes;
    private $values;

    public function __construct(
        GraphNodes $nodes,
        GraphValues $values
    ) {
        $this->nodes = $nodes;
        $this->values = $values;
    }

    public function createNode(): Node
    {
        return $this->nodes->create();
    }

    public function readNode(int $id): Node
    {
        return $this->nodes->read($id);
    }

    public function readOrCreateValue(string $contents): Value
    {
        return $this->values->create($contents);
    }

    public function readValueByNode(Node $node): Value
    {
        return $this->values->readByNode($node);
    }
}