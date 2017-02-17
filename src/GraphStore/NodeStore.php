<?php

namespace MemMemov\GraphStore;

interface NodeStore
{
    public function create(): int;

    public function read(int $id): array;

    public function connect(int $fromId, int $toId): void;

    public function contains(int $fromId, int $toId): bool;
}