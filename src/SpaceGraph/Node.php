<?php

namespace MemMemov\SpaceGraph;

class Node
{
    private $id;
    private $ids;
    private $store;

    public function __construct(
        int $id,
        array $ids,
        Store $store
    ) {
        $this->id = $id;
        $this->ids = array_map(function(int $id) {
            return $id;
        }, $ids);
        $this->store = $store;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function value(): string
    {
        return $this->store->readValue($this->id);
    }

    public function has(Node $node): bool
    {
        return in_array($node->id(), $this->ids);
    }

    /**
     * @return Node[]
     */
    public function all(): array
    {
        return array_map(function(int $id) {
            $ids = $this->store->readNode($id);
            return new Node($id, $ids, $this->store);
        }, $this->ids);
    }

    public function add(Node $node): void
    {
        $this->store->connectNodes($this->id, $node->id());
    }
}