<?php

namespace MemMemov\Cybelang\Cybe;

interface Graph
{
    public function createNode(string $type, array $toIds, array $fromIds): GraphNode;
    
    public function provideCommonNode(string $type, array $ids): GraphNode;

    public function provideValueNode(string $type, string $value): GraphNode;

    public function getNodeValue(int $id): string;

    public function readNode(string $type, int $id): GraphNode;

    /**
     * @return GraphNode[]
     */
    public function filterNode(string $type, int $id): array;

    public function provideSequenceNode(string $type, array $ids): GraphNode;

    /**
     * @return GraphNode[]
     */
    public function readSequenceNodes(string $type, int $id): array;
    
    public function addNodeToRow(int $headId, int $newTailId): void;
    
    /**
     * @return GraphNode[]
     */
    public function readRow(string $tailSpaceName, int $headId, int $limit): array;
}