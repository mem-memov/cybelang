<?php

namespace MemMemov\Cybelang\SpaceGraph\Node;

interface Store
{
    public function createNode(): int;

    /**
     * @param int $id
     * @return int[]
     */
    public function readNode(int $id): array;

    public function connectNodes(int $fromId, int $toId): void;

    public function provideNode(string $value): int;

    public function readValue(int $id): string;

    /**
     * @param int[] $nodes
     * @return int[]
     */
    public function commonNodes(array $ids): array;
    
    public function exchangeNodes(int $id, int $oldId, int $newId): void;
}