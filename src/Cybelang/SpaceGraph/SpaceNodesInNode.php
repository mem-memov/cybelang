<?php

namespace MemMemov\Cybelang\SpaceGraph;

interface SpaceNodesInNode
{
    public function getOneNode(string $spaceName, int $id): SpaceNode;

    /**
     * @param string $spaceName
     * @param int $id
     * @return SpaceNode[]
     */
    public function findNodes(string $spaceName, int $id): array;
}