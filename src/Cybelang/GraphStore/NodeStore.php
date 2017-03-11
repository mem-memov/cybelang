<?php

namespace MemMemov\Cybelang\GraphStore;

interface NodeStore
{
    public function create(): int;

    public function read(int $id): array;

    public function connect(int $fromId, int $toId): void;

    public function contains(int $fromId, int $toId): bool;

    public function intersect(array $ids): array;
    
    public function exchange(int $id, int $oldId, int $newId): void;
    
    public function exists(int $id): bool;
}