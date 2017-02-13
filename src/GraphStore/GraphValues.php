<?php

namespace MemMemov\GraphStore;

class GraphValues
{
    private $store;
    private $nodes;

    public function __construct(
        ValueStore $store,
        GraphNodes $nodes
    ) {
        $this->store = $store;
        $this->nodes = $nodes;
    }

    public function create(string $contents): GraphValue
    {
        if ($this->store->hasValue($contents)) {
            $key = $this->store->key($contents);
            $id = (int)$key;
            $node = $this->nodes->read($id);
        } else {
            $node = $this->nodes->create();
            $key = (string)$node->id();
            $this->store->bind($key, $contents);
        }

        return new GraphValue($this->store, $key, $node);
    }

    public function readByNode(GraphNode $node): GraphValue
    {
        $key = (string)$node->id();

        if (!$this->store->hasKey($key)) {
            throw new \Exception();
        }

        return new GraphValue($this->store, $key, $node);
    }

    public function readByContents(string $contents): GraphValue
    {
        $key = $this->store->key($contents);
        $id = (int)$key;
        $node = $this->nodes->read($id);

        return new GraphValue($this->store, $key, $node);
    }
}