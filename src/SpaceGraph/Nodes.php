<?php

namespace MemMemov\SpaceGraph;

class Nodes
{
    private $store;

    public function __construct(
        Store $store
    ) {
        $this->store = $store;
    }

    public function readNode(int $id): Node
    {
        $ids = $this->store->readNode($id);

        return new Node(
            $id,
            $ids,
            $this->store,
            $this
        );
    }
}