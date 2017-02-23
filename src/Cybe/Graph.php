<?php

namespace MemMemov\Cybe;

interface Graph
{
    public function provideCommonNode(string $type, array $ids): GraphNode;

    public function provideValueNode(string $type, string $value): GraphNode;

    public function getNodeValue(int $id): string;

    public function readNode(int $id): GraphNode;

    public function provideSequenceNode(string $type, array $ids): GraphNode;

    /**
     * @param int $id
     * @return GraphNode[]
     */
    public function readSequenceNodes(string $type, int $id): array;
}