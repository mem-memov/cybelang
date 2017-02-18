<?php

namespace MemMemov\SpaceGraph;

interface Graph
{
    public function createNode(): int;

    /**
     * @param int $id
     * @return int[]
     */
    public function readNode(int $id): array;

    public function provideNode(string $value): int;

    public function readValue(int $id): string;

    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function intersect(array $ids): array;
}