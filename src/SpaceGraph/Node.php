<?php

namespace MemMemov\SpaceGraph;

class Node
{
    private $id;
    private $ids;
    private $store;
    private $nodes;

    public function __construct(
        int $id,
        array $ids,
        Store $store,
        Nodes $nodes
    ) {
        $this->id = $id;
        $this->ids = array_map(function(int $id) {
            return $id;
        }, $ids);
        $this->store = $store;
        $this->nodes = $nodes;
    }

    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return Node[]
     */
    public function all(): array
    {
        return array_map(function(int $id) {
            return $this->nodes->readNode($id);
        }, $this->ids);
    }

    public function add(Node $node)
    {
        $this->store->connectNodes($this->id, $node->id());
    }
}