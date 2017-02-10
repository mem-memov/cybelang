<?php

namespace MemMemov\NodeStore;

class ArrayNodeStore implements NodeStore
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