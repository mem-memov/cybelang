<?php

namespace MemMemov\GraphStore\NodeStore;

use MemMemov\GraphStore\NodeStore as NodeStoreInterface;

class ArrayNodeStore implements NodeStoreInterface
{
    private $store;

    public function __construct()
    {
        $this->store = [];
    }

    public function create(): int
    {
        $id = count($this->store) + 1;

        $this->store[$id] = [];

        return $id;
    }

    public function read(int $id): array
    {
        return $this->store[$id];
    }

    public function connect(int $fromId, int $toId): void
    {
        if (in_array($toId, $this->store[$fromId])) {
            return;
        }

        $this->store[$fromId][] = $toId;
    }

    public function contains(int $fromId, int $toId): bool
    {
        return in_array($toId, $this->store[$fromId]);
    }
}