<?php

namespace MemMemov\NodeStore;

interface NodeStore
{
    public function create(): int;

    public function read(int $id);

    public function connect(int $fromId, int $toId): void;

    public function contains(int $fromId, int $toId): bool;
}