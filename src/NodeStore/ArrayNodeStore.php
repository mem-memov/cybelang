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

    public function read(int $id)
    {

    }

    public function connect(int $fromId, int $toId): void
    {

    }

    public function contains(int $id, array $ids): bool
    {

    }
}