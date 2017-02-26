<?php

namespace MemMemov\Cybelang\SpaceGraph;

interface SpaceNodesInGraph
{
    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     * @throws ForbidMultipleCommonNodes
     */
    public function provideCommonNode(string $spaceName, array $ids): SpaceNode;

    public function provideNodeForValue(string $spaceName, string $value): SpaceNode;

    public function valueOfNode(int $id): string;

    public function readNode(int $id): SpaceNode;

    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     */
    public function provideSequenceNode(string $spaceName, array $ids): SpaceNode;

    /**
     * @param string $spaceName
     * @param int $id
     * @return SpaceNode[]
     */
    public function readNodeSequence(string $spaceName, int $id): array;
}