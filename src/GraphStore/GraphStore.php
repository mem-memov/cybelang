<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node;
use MemMemov\SpaceGraph\Value;
use MemMemov\SpaceGraph\Graph;

class GraphStore implements Graph
{
    private $nodeStore;
    private $valueStore;

    public function __construct(
        NodeStore $nodeStore,
        ValueStore $valueStore
    ) {
        $this->nodeStore = $nodeStore;
        $this->valueStore = $valueStore;
    }

    public function createNode(): int
    {
        return $this->nodeStore->create();
    }

    public function readNode(int $id): array
    {
        return $this->nodeStore->read($id);
    }

    public function provideNode(string $value): int
    {
        if ($this->valueStore->hasValue($value)) {
            $id = (int)$this->valueStore->key($contents);
        } else {
            $id = $this->nodeStore->create();
            $this->store->bind((string)$id, $value);
        }

        return $id;
    }

    public function readValue(int $id): string
    {
        return $this->valueStore->value((string)$id);
    }

    public function commonNodes(array $ids): array
    {
        return $this->nodeStore->intersect($ids);
    }
}