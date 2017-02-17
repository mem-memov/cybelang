<?php

namespace MemMemov\SpaceGraph;

class Space
{
    private $value;
    private $graph;

    public function __construct(
        $value,
        $graph
    ) {
        $this->value = $value;
        $this->graph = $graph;
    }

    public function has(Node $node): bool
    {
        return $node->has($this->value);
    }

    public function add(Node $node): void
    {
        $node->addNode($this->value);
    }
}