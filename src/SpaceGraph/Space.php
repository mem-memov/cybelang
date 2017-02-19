<?php

namespace MemMemov\SpaceGraph;

class Space
{
    private $name;
    private $id;
    private $store;

    public function __construct(
        string $name,
        int $id,
        Store $store
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->store = $store;
    }

    public function create(): Node
    {
        $id = $this->store->createNode();
        $this->store->connectNodes($id, $this->id);

        return new Node(
            $id,
            [$this->id],
            $this->store
        );
    }

    public function read(int $id): Node
    {
        $ids = $this->store->readNode($id);

        if (!in_array($this->id, $ids)) {
            throw new \Exception(sprintf('Node %d is not from space %s(%d)', $id, $this->name, $this->id));
        }

        return new Node(
            $id,
            $ids,
            $this->store
        );
    }

    public function filter(array $ids): array
    {

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