<?php

namespace MemMemov\Cybelang\SpaceGraph;

interface SpaceNodesInGraph
{
    public function createNode(string $spaceName, array $toIds, array $fromIds): SpaceNode;
    
    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     * @throws ForbidMultipleCommonNodes
     */
    public function provideCommonNode(string $spaceName, array $ids): SpaceNode;

    public function provideNodeForValue(string $spaceName, string $value): SpaceNode;

    public function valueOfNode(int $id): string;

    public function readNode(string $spaceName, int $id): SpaceNode;
    
    /**
     * @return SpaceNode[]
     */
    public function filterNode(string $spaceName, int $id): array;

    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     */
    public function provideSequenceNode(string $spaceName, array $ids): SpaceNode;

    /**
     * @return SpaceNode[]
     */
    public function readNodeSequence(string $spaceName, int $id): array;
    
    public function addNodeToRow(int $id, int $newId): void;
    
    /**
     * @return GraphNode[]
     */
    public function readRow(string $type, int $id, int $limit): array;
}