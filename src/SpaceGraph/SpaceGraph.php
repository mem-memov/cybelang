<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\Graph;
use MemMemov\Cybe\GraphNode;

class SpaceGraph implements Graph
{
    private $spaceNodes;

    public function __construct(
        SpaceNodes $spaceNodes
    ) {
        $this->spaceNodes = $spaceNodes;
    }

    public function provideCommonNode(string $type, array $ids): GraphNode
    {
        return $this->spaceNodes->provideCommonNode($type, $ids);
    }

    public function provideValueNode(string $type, string $value): GraphNode
    {
        return $this->spaceNodes->provideNodeForValue($type, $value);
    }

    public function getNodeValue(int $id): string
    {
        return $this->spaceNodes->valueOfNode($id);
    }

    public function readNode(int $id): GraphNode
    {
        return $this->spaceNodes->readNode($id);
    }

    public function provideSequenceNode(string $type, array $ids): GraphNode
    {
        return $this->spaceNodes->provideSequenceNode($type, $ids);
    }

    /**
     * @param int $id
     * @return GraphNode[]
     */
    public function readSequenceNodes(string $type, int $id): array
    {
        return $this->spaceNodes->readNodeSequence($type, $id);
    }
}