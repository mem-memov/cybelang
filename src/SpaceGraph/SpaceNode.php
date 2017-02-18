<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\GraphNode;

class SpaceNode implements GraphNode
{
    private $node;
    private $spaceNodes;

    public function __construct(
        Node $node,
        SpaceNodes $spaceNodes
    ) {
        $this->node = $node;
        $this->spaceNodes = $spaceNodes;
    }

    public function id(): int
    {
        return $this->node->id();
    }



    public function one(string $type): GraphNode
    {
        foreach ($this->node->all() as $node) {

        }
        $ids = $this->store->readNode($this->id);
        $space = $this->spaces->provideSpace($type);

        $one;

        return $this->spaceNodes->spaceNode($one);
    }

    public function all(string $type, callable $use): void
    {
        $nodes = array_map();
    }
}