<?php

namespace MemMemov\SpaceGraph;

class Space
{
    private $id;
    private $store;

    public function __construct(
        int $id,
        Store $store
    ) {
        $this->id = $id;
        $this->store = $store;
    }

    public function has(int $id): bool
    {
        return $this->store->contains($id, $this->id);
    }

    public function add(Node $node): void
    {
        $node->addNode($this->value);
    }
}