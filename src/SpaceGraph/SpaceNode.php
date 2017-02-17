<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\GraphNode;

class SpaceNode implements GraphNode
{
    private $node;
    private $spaces;

    public function __construct(
        Node $node,
        Spaces $spaces
    ) {
        $this->node = $node;
        $this->spaces = $spaces;
    }

    public function id(): int
    {
        return $this->node->id();
    }

    public function one(string $type): GraphNode
    {
        $space = $this->spaces->createSpace($type);


    }

    public function all(string $type, callable $use): void
    {

    }
}