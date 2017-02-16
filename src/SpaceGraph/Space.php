<?php

namespace MemMemov\SpaceGraph;

class Space
{
    private $value;

    public function __construct(
        $value
    ) {
        $this->value = $value;
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